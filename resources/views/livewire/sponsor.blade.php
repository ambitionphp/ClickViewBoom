<div>
    @push('scripts')
        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    @endpush
    <div class="max-w-xl mx-auto py-2 px-6 lg:px-8">

        <h1 class="font-semibold text-xl mb-2">Sponsors</h1>

        <p class="text-sm mb-3">{{ config('app.name') }} remains online mainly by the support of it's sponsors. We provide complete transparency with our contributions.</p>

        <div class="grid grid-cols-3 gap-4 my-5">
            <div class="bg-gray-200 px-2 py-1 rounded text-center">
                <span class="text-xs uppercase">
                    Domain*
                </span>
                <div>
                    <span class="text-lg font-semibold">
                        {{ $this->domain_expires }}
                    </span>
                </div>
                <span class="text-xs uppercase">
                    Remaining
                </span>
            </div>
            <div class="bg-gray-200 px-2 py-1 rounded text-center">
                <span class="text-xs uppercase">
                    Hosting**
                </span>
                <div>
                    <span class="text-lg font-semibold">
                        {{ $this->hosting_expires }}
                    </span>
                </div>
                <span class="text-xs uppercase">
                    Remaining
                </span>
            </div>
            <div class="bg-gray-200 px-2 py-1 rounded text-center">
                    <span class="text-xs uppercase">
                        Coffees***
                    </span>
                <div>
                    <span class="text-lg font-semibold">
                        {{ number_format($this->coffee_count) }}
                    </span>
                </div>
                <span class="text-xs uppercase">
                    Consumed
                </span>
            </div>
        </div>

        @if( ! $doContribute )
            <div class="grid grid-cols-5 md:grid-cols-3 gap-4 mt-5">
                <div class="col-span-3 md:col-span-2 text-sm">
                    Would you like to sponsor the the development and longevity of {{ config('app.name') }}?
                </div>
                <div class="col-span-2 md:col-span-1 self-center">
                    <button type="button" wire:click="$set('doContribute', true)" class="w-full px-4 py-2 bg-gray-800 text-center border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition shadow-xl">
                        Sponsor
                    </button>
                </div>
            </div>
        @else
            @if($completed)
                <div>
                    <div class="mt-5 mb-3">
                        <h1 class="font-semibold text-lg text-green-600 mb-2">Payment successful</h1>
                    </div>

                    <p>Awesome people like you keep the Internet alive. Your contribution will help increase the longevity of this project and we greatly appreciate it.</p>
                </div>
            @elseif( $payment )
                <div>
                    <div class="mt-5 mb-3">
                        <h1 class="font-semibold text-lg mb-2">Payment details</h1>
                    </div>

                    <div class="flex mb-3">
                        <div class="flex-none self-center">
                            @if($image)
                                <div class="flex rounded-full w-12 h-12" style="background-image:url({{ $image->temporaryUrl() }});background-size:cover;background-position:center center;"></div>
                            @else
                                <div class="flex rounded-full w-12 h-12 bg-gray-200 text-gray-700">
                                    <i class="fa fa-user-secret fa-fw self-center mx-auto mb-1"></i>
                                </div>
                            @endif
                        </div>
                        <div class="grow self-center">
                            <div class="px-3">
                                <span class="block font-semibold">{{ $name }}</span>
                                <span class="block text-gray-400 text-sm">{{ $url }}</span>
                            </div>
                        </div>
                        <div class="flex-none self-center pt-1">
                            <span class="text-green-600 text-sm font-semibold">${{ number_format($contributionCustom??$contribution,2) }}</span>
                        </div>
                        <div class="flex-none self-center">
                            <div class="h-16 w-16">
                                <livewire:livewire-pie-chart
                                    key="{{ $pieChartModel->reactiveKey() }}"
                                    :pie-chart-model="$pieChartModel"
                                />
                            </div>
                        </div>
                    </div>

                    <div x-data="
                        {
                            cardName: @entangle('cardName'),
                            cardNumber: '',
                            cardExpMonth: @entangle('cardExpMonth'),
                            cardExpYear: @entangle('cardExpYear'),
                            cardCode: '',
                            process() {
                                Stripe.setPublishableKey('{{ config('services.stripe.key') }}');
                                Stripe.createToken({
                                    number: this.cardNumber,
                                    cvc: this.cardCode,
                                    exp_month: this.cardExpMonth,
                                    exp_year: this.cardExpYear
                                }, this.stripeResponseHandler);
                            },
                            doError(type) {
                                this[type] = 1;
                            },
                            stripeResponseHandler(status, response) {
                                if (response.error) {
                                    alert(response.error.message);
                                } else {
                                    $wire.takePayment(response['id'])
                                }
                            }
                        }
                    ">
                        <div class="mb-1">
                            <label class="font-bold text-sm mb-2 ml-1">Name on card</label>
                            <div>
                                <input x-model="cardName" class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" placeholder="John Smith" type="text"/>
                            </div>
                        </div>
                        <div class="mb-1">
                            <label class="font-bold text-sm mb-2 ml-1">Card number</label>
                            <div>
                                <input x-model="cardNumber" data-inputmask="'mask': '9999 9999 9999 9999'" class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" placeholder="0000 0000 0000 0000" type="text"/>
                            </div>
                        </div>
                        <div class="mb-1 -mx-2 flex items-end">
                            <div class="px-2 w-1/2">
                                <label class="font-bold text-sm mb-2 ml-1">Expiration date</label>
                                <div>
                                    <select x-model="cardExpMonth" class="form-select w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors cursor-pointer">
                                        <option value="01">01 - January</option>
                                        <option value="02">02 - February</option>
                                        <option value="03">03 - March</option>
                                        <option value="04">04 - April</option>
                                        <option value="05">05 - May</option>
                                        <option value="06">06 - June</option>
                                        <option value="07">07 - July</option>
                                        <option value="08">08 - August</option>
                                        <option value="09">09 - September</option>
                                        <option value="10">10 - October</option>
                                        <option value="11">11 - November</option>
                                        <option value="12">12 - December</option>
                                    </select>
                                </div>
                            </div>
                            <div class="px-2 w-1/2">
                                <select x-model="cardExpYear" class="form-select w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors cursor-pointer">
                                    @foreach($cardExpYears AS $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="font-bold text-sm mb-2 ml-1">Security code</label>
                            <div>
                                <input x-model="cardCode" class="w-32 px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" placeholder="000" type="text"/>
                            </div>
                        </div>
                        <div>
                            <button @click="process" type="button" class="w-full px-4 py-2 bg-gray-800 text-center border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition shadow-xl">
                                Process payment
                            </button>
                        </div>
                    </div>
                </div>
            @elseif( $details )
                <div>
                    <div class="mt-5">
                        <h1 class="font-semibold text-lg mb-2">Sponsor details</h1>
                    </div>

                    <div class="flex mt-3">
                        <div class="flex-none self-center">
                            <input type="file" wire:model="image" class="hidden" id="image_input">
                            @if ($image)
                                <div onclick="document.getElementById('image_input').click()" class="flex rounded-full w-20 h-20 cursor-pointer" style="background-image:url({{ $image->temporaryUrl() }});background-size:cover;background-position:center center;"></div>
                            @else
                                <div onclick="document.getElementById('image_input').click()" class="flex rounded-full w-20 h-20 bg-gray-200 text-gray-700 cursor-pointer">
                                    <i class="fa fa-user-secret fa-2x fa-fw self-center mx-auto mb-1"></i>
                                </div>
                            @endif
                        </div>
                        <div class="grow self-center">
                            <div class="pl-3">
                                <div class="relative flex w-full flex-wrap items-stretch mb-2">
                                  <span class="z-10 h-full leading-snug font-normal absolute text-center text-gray-700 absolute bg-transparent rounded text-sm items-center justify-center w-8 pl-3 py-3">
                                    <i class="fas fa-user"></i>
                                  </span>
                                    <input wire:model.defer="name" type="text" placeholder="Name or Company" class="px-3 py-2.5 text-gray-700 relative bg-white bg-white rounded text-sm {{ $errors->has('name') ? 'border border-red-600' : 'border-0' }} outline-none focus:outline-none focus:ring w-full pl-10"/>
                                </div>

                                <div class="relative flex w-full flex-wrap items-stretch mb-2">
                                  <span class="z-10 h-full leading-snug font-normal absolute text-center text-gray-700 absolute bg-transparent rounded text-sm items-center justify-center w-8 pl-3 py-3">
                                    <i class="fas fa-envelope"></i>
                                  </span>
                                    <input wire:model.defer="email" type="email" placeholder="Email Address" class="px-3 py-2.5 text-gray-700 relative bg-white bg-white rounded text-sm {{ $errors->has('email') ? 'border border-red-600' : 'border-0' }} outline-none focus:outline-none focus:ring w-full pl-10"/>
                                </div>

                                <div class="relative flex w-full flex-wrap items-stretch mb-2">
                                  <span class="z-10 h-full leading-snug font-normal absolute text-center text-gray-700 absolute bg-transparent rounded text-sm items-center justify-center w-8 pl-3 py-3">
                                    <i class="fas fa-globe"></i>
                                  </span>
                                    <input wire:model.defer="url" type="url" placeholder="Website or Social Profile" class="px-3 py-2.5 text-gray-700 relative bg-white bg-white rounded text-sm border-0 outline-none focus:outline-none focus:ring w-full pl-10"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex pt-3">
                        <div class="grow">
                            <button type="button" wire:click="continueToPaymentDetails" class="w-full px-4 py-2 bg-gray-800 text-center border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition shadow-xl">
                                Make payment
                            </button>
                        </div>
                        <div class="flex-none pl-2">
                            <button type="button" wire:click="bail" class="w-full px-4 py-2 bg-gray-500 text-center border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 active:bg-gray-600 focus:outline-none focus:border-gray-600 focus:ring focus:ring-gray-600 disabled:opacity-25 transition shadow-xl">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div>
                    <div class="mt-5">
                        <h1 class="font-semibold text-lg mb-2">Contribution</h1>
                    </div>
                    <div class="flex">
                        <div class="no-flex pr-2">
                            <div wire:key="contribute_5" wire:click="setContribution(5)" class="w-11 cursor-pointer py-2.5 text-center font-bold text-sm {{ null === $contributionCustom && $contribution === 5 ? 'bg-gray-500 text-gray-50' : 'bg-gray-300 text-gray-700' }} rounded">
                                $5
                            </div>
                        </div>
                        <div class="no-flex pr-2">
                            <div wire:key="contribute_10" wire:click="setContribution(10)" class="w-11 cursor-pointer py-2.5 text-center font-bold text-sm {{ null === $contributionCustom && $contribution === 10 ? 'bg-gray-500 text-gray-50' : 'bg-gray-300 text-gray-700' }} rounded">
                                $10
                            </div>
                        </div>
                        <div class="no-flex pr-2">
                            <div wire:key="contribute_25" wire:click="setContribution(25)" class="w-11 cursor-pointer py-2.5 text-center font-bold text-sm {{ null === $contributionCustom && $contribution === 25 ? 'bg-gray-500 text-gray-50' : 'bg-gray-300 text-gray-700' }} rounded">
                                $25
                            </div>
                        </div>
                        <div class="no-flex pr-2">
                            <div wire:key="contribute_50" wire:click="setContribution(50)" class="w-11 cursor-pointer py-2.5 text-center font-bold text-sm {{ null === $contributionCustom && $contribution === 50 ? 'bg-gray-500 text-gray-50' : 'bg-gray-300 text-gray-700' }} rounded">
                                $50
                            </div>
                        </div>
                        <div class="grow">
                            <div class="relative flex w-full flex-wrap items-stretch mb-3">
                          <span class="z-10 h-full leading-snug font-normal absolute text-center text-gray-700 absolute bg-transparent rounded text-sm items-center justify-center w-8 pl-3 py-3">
                            <i class="fas fa-dollar-sign"></i>
                          </span>
                                <input wire:model="contributionCustom" type="text" placeholder="0.00" class="px-3 py-2.5 text-gray-700 relative bg-white bg-white rounded text-sm {{ !$contributionCustomError ? 'border-0' : 'border border-red-600' }} outline-none focus:outline-none focus:ring w-full pl-10"/>
                            </div>
                        </div>
                    </div>

                    <div class="flex mb-4">
                        <div class="grow self-center">
                            <label for="domain" class="relative flex items-center cursor-pointer mb-2">
                                <input wire:model="domain" type="checkbox" id="domain" class="sr-only peer" />
                                <div class="h-6 bg-gray-200 border-2 border-gray-200 rounded-full w-11 after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border after:border-gray-300 after:h-5 after:w-5 after:shadow-sm after:rounded-full peer-checked:after:translate-x-full peer-checked:after:border-white peer-checked:bg-violet-300 peer-checked:border-violet-300 after:transition-all after:duration-300"></div>
                                <span class="ml-2 text-base text-gray-800">Domain lifetime</span>
                            </label>

                            <label for="hosting" class="relative flex items-center cursor-pointer mb-2">
                                <input wire:model="hosting" type="checkbox" id="hosting" class="sr-only peer" />
                                <div class="h-6 bg-gray-200 border-2 border-gray-200 rounded-full w-11 after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border after:border-gray-300 after:h-5 after:w-5 after:shadow-sm after:rounded-full peer-checked:after:translate-x-full peer-checked:after:border-white peer-checked:bg-blue-300 peer-checked:border-blue-300 after:transition-all after:duration-300"></div>
                                <span class="ml-2 text-base text-gray-800">Hosting lifetime</span>
                            </label>

                            <label for="coffee" class="relative flex items-center cursor-pointer">
                                <input wire:model="coffee" type="checkbox" id="coffee" class="sr-only peer" />
                                <div class="h-6 bg-gray-200 border-2 border-gray-200 rounded-full w-11 after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border after:border-gray-300 after:h-5 after:w-5 after:shadow-sm after:rounded-full peer-checked:after:translate-x-full peer-checked:after:border-white peer-checked:bg-orange-300 peer-checked:border-orange-300 after:transition-all after:duration-300"></div>
                                <span class="ml-2 text-base text-gray-800">Coffee</span>
                            </label>
                        </div>
                        <div class="no-flex">
                            <div class="w-28 h-28">
                                <livewire:livewire-pie-chart
                                    key="{{ $pieChartModel->reactiveKey() }}"
                                    :pie-chart-model="$pieChartModel"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="grow">
                            <button type="button" wire:click="continueToDetails" class="w-full px-4 py-2 bg-gray-800 text-center border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition shadow-xl">
                                Continue
                            </button>
                        </div>
                        <div class="flex-none pl-2">
                            <button type="button" wire:click="bail" class="w-full px-4 py-2 bg-gray-500 text-center border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 active:bg-gray-600 focus:outline-none focus:border-gray-600 focus:ring focus:ring-gray-600 disabled:opacity-25 transition shadow-xl">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        <div class="my-3">
            <p class="text-xs text-center"><span class="font-bold">*</span> domain based at $15/year</p>
            <p class="text-xs text-center"><span class="font-bold">**</span> hosting based at $35/month</p>
            <p class="text-xs text-center"><span class="font-bold">***</span> coffee based at $5/per cup</p>
        </div>

        @if($contributions->count())
            <div>
                <div class="">
                    <h1 class="font-semibold text-lg mb-2">Our Sponsors</h1>
                </div>

                <div class="mb-3">
                    @foreach($contributions AS $contribution)
                        <hr class="my-4 border-gray-200" />

                        <div class="flex mt-3">
                            <div class="flex-none self-center">
                                @if($contribution->image_path)
                                    <img src="{{ $contribution->image_url }}" class="rounded-full w-12">
                                @else
                                    <div class="flex rounded-full w-12 h-12 bg-gray-200 text-gray-700">
                                        <i class="fa fa-user-secret fa-fw self-center mx-auto mb-1"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="grow self-center">
                                <div class="px-3">
                                    <span class="block font-semibold">{{ $contribution->name }}</span>
                                    <span class="block text-gray-400 text-sm">{{ $contribution->url }}</span>
                                </div>
                            </div>
                            <div class="flex-none self-center pt-1">
                                <span class="text-green-600 text-sm font-semibold">{{ $contribution->amount_string }}</span>
                            </div>
                            <div class="flex-none self-center">
                                <div class="h-16 w-16">
                                    <livewire:livewire-pie-chart
                                        key="{{ $contribution->pieChartModel->reactiveKey() }}"
                                        :pie-chart-model="$contribution->pieChartModel"
                                    />
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mb-3">
                    {{ $contributions->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
