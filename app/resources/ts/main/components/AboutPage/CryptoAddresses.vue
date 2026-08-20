<script setup lang="ts">
import CryptoAddress from '@/components/AboutPage/CryptoAddress.vue'

const addresses = [
    {
        name: 'BTC',
        address: 'bc1qfjrma259z5mhtcaauwk0lpjt3mw2nlgtv8cr2w',
    },
    {
        name: 'ETH',
        address: '0x9d9a053E67635a77Ad12835E8fFb3636c3cf1f28',
    },
    {
        name: 'XMR',
        address: '4246M3ekqZb3xuQgM4NZVngiQFDbaRGQN84WgJd44ef18frssKtuE4PiU3WVHwFB9DZS66vNkkaz4aMCSGzeLpo14s8XX5e',
    },
]
</script>

<template>
    <div class="flex flex-col gap-2 px-4 mt-3">
        <CryptoAddress
            v-for="address in addresses"
            :key="address.name"
            :name="address.name"
            :address="address.address"
        />
    </div>
</template>
