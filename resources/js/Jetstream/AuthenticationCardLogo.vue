<template>
    <inertia-link :href="'/'">
        <img
            class="h-6"
            :src="
                $store.state.theme == 'light'
                    ? '/images/flaremetrics-logo-sm.png'
                    : '/images/flaremetrics-logo-sm-light.png'
            "
            alt=""
        />
    </inertia-link>
</template>
