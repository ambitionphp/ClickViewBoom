<?php

namespace App\Http\Livewire;

use App\Models\Contribution;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Stripe\Charge;
use Stripe\Stripe;

class Sponsor extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $doContribute = false;
    public $contribution = 5;
    public $contributionCustom;
    public $contributionCustomError = false;
    public $coffee = true;
    public $domain = false;
    public $hosting = false;
    public $details = false;
    public $image;
    public $name;
    public $email;
    public $url;
    public $payment = false;
    public $cardName;
    public $cardNumber;
    public $cardExpMonth = '01';
    public $cardExpYear;
    public $cardExpYears;
    public $code;
    public $completed = false;

    public function bail()
    {
        $this->doContribute = false;
        $this->details = false;
        $this->payment = false;
    }

    public function mount()
    {
        $this->cardExpYear = now()->year;
        for($i=0;$i<10;$i++) {
            $this->cardExpYears[] = now()->addYears($i)->year;
        }
    }

    public function render()
    {
        $enabled = 0;
        if($this->coffee)
            $enabled++;
        if($this->domain)
            $enabled++;
        if($this->hosting)
            $enabled++;

        $per = $enabled ? ($this->contributionCustom??$this->contribution) / $enabled : 0;

        $pieChartModel = (new PieChartModel())->withoutLegend();
        if($this->coffee)
            $pieChartModel = $pieChartModel->addSlice('Coffee', $per, '#fdba74');
        if($this->domain)
            $pieChartModel = $pieChartModel->addSlice('Domain', $per, '#c4b5fd');
        if($this->hosting)
            $pieChartModel = $pieChartModel->addSlice('Hosting', $per, '#93c5fd');

        return view('livewire.sponsor', [
            'pieChartModel' => $pieChartModel,
            'contributions' => Contribution::orderBy('id', 'desc')->paginate(15)
        ]);
    }

    public function getDomainExpiresProperty()
    {
        $days = \App\Helpers\Contribute::days('domain', Contribution::orderBy('id', 'desc')->sum('domain'));
        return Carbon::parse(config('boom.birthday'))->diff(Carbon::parse(config('boom.birthday'))->addDays($days))->format('%yy %mmo');
    }

    public function getHostingExpiresProperty()
    {
        $days = \App\Helpers\Contribute::days('hosting', Contribution::orderBy('id', 'desc')->sum('hosting'));
        return Carbon::parse(config('boom.birthday'))->diff(Carbon::parse(config('boom.birthday'))->addDays($days))->format('%yy %mmo');
    }

    public function getCoffeeCountProperty()
    {
        return (int) ( ( Contribution::orderBy('id', 'desc')->sum('coffee') / 100 ) / config('boom.contributions.coffee.per') );
    }

    public function updatedContributionCustom() {
        if( $this->contributionCustom ) {
            $this->contribution = null;
        }
        else {
            $this->contribution = $this->contribution ?? 5;
        }
    }

    public function setContribution($amount) {
        $this->contribution = (int) $amount;
        $this->contributionCustom = null;
    }

    public function continueToDetails() {
        if( $this->contributionCustom && $this->contributionCustom < 5 ) {
            $this->contributionCustomError = true;
        }
        elseif( ! $this->domain && ! $this->hosting && ! $this->coffee ) {

        }
        else {
            $this->contributionCustomError = false;
            $this->details = true;
        }
    }

    public function updatedImage()
    {
        $this->validate([
            'image' => 'image|max:1024',
        ]);
    }

    public function continueToPaymentDetails() {
        $this->validate([
            'name' => 'required',
            'email' => ['required','email'],
        ]);

        $this->cardName = $this->name;

        $this->payment = true;
    }

    public function takePayment($token) {
        Stripe::setApiKey(config('services.stripe.secret'));
        $charge = Charge::create ([
            "amount" => ($this->contributionCustom ?? $this->contribution) * 100,
            "currency" => "usd",
            "source" => $token,
            "description" => "Contribution to ".config('app.name')
        ]);
        if( $charge->captured ) {
            $this->completed = true;

            $enabled = 0;
            if($this->coffee)
                $enabled++;
            if($this->domain)
                $enabled++;
            if($this->hosting)
                $enabled++;

            $contribution = Contribution::create([
                'name' => $this->name,
                'image_path' => $this->image ?$this->image->storePublicly('photos') : null,
                'email' => $this->email,
                'url' => $this->url,
                'stripe_token' => $token,
                'domain' => (int) ($this->domain ? $charge->amount_captured / $enabled : 0),
                'hosting' => (int) ($this->hosting ? $charge->amount_captured / $enabled : 0),
                'coffee' => (int) ($this->coffee ? $charge->amount_captured / $enabled : 0),
                'amount' => $charge->amount_captured,
                'paid_at' => now()
            ]);

            dispatch(function () use ($contribution) {
                Mail::to($this->email)->send(new \App\Mail\Contribution($contribution));
            })->afterResponse();
        }
    }
}
