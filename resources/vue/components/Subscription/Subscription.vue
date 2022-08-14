<script setup lang="ts">

</script>

<template>
    <footer class="bg-gradient bg-gradient-to-r from-gray-800 to-gray-700 text-white px-8 py-24">
        <form action="" method="post" class="w-[480px] mx-auto">
            <label
                for="subscription"
                class="block mb-4 text-2xl text-center drop-shadow-md"
            >
                Subscribe to get the latest posts
            </label>

            <div class="flex h-[53px] bg-gray-600 p-1 inline-block rounded-full shadow-sm">
                <input
                    type="email"
                    id="subscription"
                    class="px-6 h-full bg-transparent w-full focus:outline-none text-white placeholder-gray-300"
                    placeholder="Your email address"
                >

                <button
                    type="submit"
                    class="bg-white h-full text-gray-700 px-7 rounded-full"
                >
                    Subscribe
                </button>
            </div>
        </form>
    </footer>
</template>
