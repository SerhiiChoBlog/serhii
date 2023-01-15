<script setup lang="ts">
import axios from 'axios'
import listenEvent from '@admin/modules/listenEvent'
import appConfig from '@admin/appConfig'
import showToast from '@admin/modules/showToast'

listenEvent(appConfig.events.logout, logout)

function logout(): void {
    if (!confirm('Are you sure you want to logout?'))
        return

    axios.post('/logout')
        .then(resp => {
            showToast({ text: `You've been logged out` })
            window.location.href = '/login'
        })
        .catch(err => console.error(err))
}
</script>

<template></template>
