<div class="shadow-xl pt-1 sm:rounded-lg" x-data="{ clicked: false }">
    <button x-show="!clicked" @click="clicked=true" type="submit" class="w-full px-4 py-2 bg-red-500 text-center border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 active:bg-red-600 focus:outline-none focus:border-red-600 focus:ring focus:ring-red-600 disabled:opacity-25 transition shadow-xl">
        Emergency Flush
    </button>
    <button x-show="clicked" wire:click="confirmed" type="submit" class="w-full px-4 py-2 bg-red-500 text-center border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 active:bg-red-600 focus:outline-none focus:border-red-600 focus:ring focus:ring-red-600 disabled:opacity-25 transition shadow-xl">
        Click to confirm
    </button>
</div>
