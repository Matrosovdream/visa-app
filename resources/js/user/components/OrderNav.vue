<template>
    <nav class="account-sidebar">
        <router-link :to="{ name: 'account.orders' }" class="account-sidebar__item">
            ← {{ $t('All orders') }}
        </router-link>
        <router-link :to="{ name: 'account.order', params: { id } }"
            class="account-sidebar__item"
            active-class="account-sidebar__item--active" exact-active-class="account-sidebar__item--active">
            {{ $t('Overview') }}
        </router-link>
        <router-link :to="{ name: 'account.order.trip', params: { id } }"
            class="account-sidebar__item"
            active-class="account-sidebar__item--active">
            {{ $t('Trip details') }}
        </router-link>
        <router-link :to="{ name: 'account.order.documents', params: { id } }"
            class="account-sidebar__item"
            active-class="account-sidebar__item--active">
            {{ $t('Documents') }}
        </router-link>

        <div class="account-sidebar__section" v-if="travellers.length">
            {{ $t('Applicants') }}
        </div>
        <div v-for="t in travellers" :key="t.id" class="account-sidebar__group">
            <div class="account-sidebar__group-title">
                {{ t.full_name || `${t.name || ''} ${t.lastname || ''}`.trim() || `#${t.id}` }}
            </div>
            <router-link v-for="sec in sections" :key="sec.name"
                :to="{ name: `account.order.applicant.${sec.name}`, params: { id, applicantId: t.id } }"
                class="account-sidebar__item account-sidebar__item--nested"
                active-class="account-sidebar__item--active">
                {{ $t(sec.label) }}
            </router-link>
        </div>
    </nav>
</template>

<script setup>
defineProps({
    id: { type: [String, Number], required: true },
    travellers: { type: Array, default: () => [] },
});

const sections = [
    { name: 'personal',    label: 'Personal' },
    { name: 'passport',    label: 'Passport' },
    { name: 'family',      label: 'Family' },
    { name: 'past-travel', label: 'Past travel' },
    { name: 'declarations', label: 'Declarations' },
    { name: 'documents',   label: 'Documents' },
];
</script>

<style>
.account-sidebar__section {
    padding: 12px 14px 6px;
    font-size: 0.68rem;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: #97a2ae;
}
.account-sidebar__group-title {
    padding: 6px 14px;
    font-size: 0.85rem;
    font-weight: 600;
    color: #495057;
}
.account-sidebar__item--nested {
    padding-left: 26px !important;
    font-size: 0.88rem;
}
</style>
