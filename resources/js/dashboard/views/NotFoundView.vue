<template>
    <div class="adm-card adm-empty">
        <h3 style="margin: 0 0 8px;">Page not found</h3>
        <p class="adm-text-muted">The admin page you're looking for doesn't exist.</p>
        <router-link :to="{ name: 'dashboard.home' }" class="adm-btn adm-btn--primary">
            Back to dashboard
        </router-link>
    </div>
</template>
