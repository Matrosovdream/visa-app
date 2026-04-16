<template>
    <header class="site-header header-style-one">
        <div class="header__top-wrap gray-bg">
            <div class="container">
                <div class="header__top ul_li_between">
                    <div class="header__top-cta">
                        <img :src="asset('user/assets/img/icon/n_pad.svg')" alt="">
                        <span>Help Desk:</span>
                        {{ globals.siteSettings?.phone }}
                    </div>
                    <ul class="header__top-info ul_li">
                        <li>
                            <img :src="asset('user/assets/img/icon/time.svg')" alt="">
                            {{ globals.siteSettings?.work_time }}
                        </li>
                        <li>
                            <img :src="asset('user/assets/img/icon/location.svg')" alt="">
                            {{ globals.siteSettings?.address }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="header__wrap stricky">
            <div class="container">
                <div class="header__inner ul_li_between">
                    <div class="header__logo">
                        <router-link to="/">
                            <img :src="asset('user/assets/img/logo/logo.svg')" alt="">
                        </router-link>
                    </div>

                    <div class="main-menu__wrap ul_li navbar navbar-expand-lg">
                        <nav class="main-menu collapse navbar-collapse">
                            <ul class="menu-top">
                                <li v-for="(menu, i) in globals.menuTop" :key="i"
                                    :class="{ 'menu-item-has-children': menu.childs?.length }">
                                    <SmartLink :href="menu.url">
                                        <span>{{ menu.title }}</span>
                                    </SmartLink>
                                    <ul v-if="menu.childs?.length" class="submenu">
                                        <li v-for="(sub, j) in menu.childs" :key="j" class="menu-item">
                                            <SmartLink :href="sub.url">
                                                <span>{{ sub.title }}</span>
                                            </SmartLink>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <ul class="header__action ul_li">
                        <li v-if="auth.isAuthenticated">
                            <div class="header__language">
                                <ul>
                                    <li>
                                        <a href="#" class="lang-btn" @click.prevent>
                                            <div class="flag">
                                                <img :src="asset('user/assets/img/icon/c_user.svg')" alt="">
                                            </div>
                                            {{ auth.user?.name || 'Account' }}
                                            <div class="arrow_down">
                                                <img :src="asset('user/assets/img/icon/arrow_down.svg')" alt="">
                                            </div>
                                        </a>
                                        <ul class="lang_sub_list">
                                            <li><SmartLink href="/account">Account</SmartLink></li>
                                            <li><SmartLink href="/account/orders">Orders</SmartLink></li>
                                            <li>
                                                <a href="#" @click.prevent="handleLogout">Log out</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li v-else>
                            <div class="header__language">
                                <ul>
                                    <li>
                                        <router-link to="/login" class="lang-btn">
                                            <div class="flag">
                                                <img :src="asset('user/assets/img/icon/c_user.svg')" alt="">
                                            </div>
                                            Login
                                        </router-link>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li v-if="globals.activeLanguage">
                            <div class="header__language">
                                <ul>
                                    <li>
                                        <a href="#" class="lang-btn" @click.prevent>
                                            <div class="flag">
                                                <img :src="asset('user/assets/img/icon/us_flag.png')" alt="">
                                            </div>
                                            {{ globals.activeLanguage.name }}
                                            <div class="arrow_down">
                                                <img :src="asset('user/assets/img/icon/arrow_down.svg')" alt="">
                                            </div>
                                        </a>
                                        <ul class="lang_sub_list">
                                            <li v-for="lang in globals.languages" :key="lang.code">
                                                <a href="#" @click.prevent="setLanguage(lang.code)">
                                                    {{ lang.name }}
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li v-if="globals.activeCurrency">
                            <div class="header__language">
                                <ul>
                                    <li>
                                        <a href="#" class="lang-btn" @click.prevent>
                                            <span>{{ globals.activeCurrency.symbol }}</span>
                                            {{ globals.activeCurrency.name }}
                                            <div class="arrow_down">
                                                <img :src="asset('user/assets/img/icon/arrow_down.svg')" alt="">
                                            </div>
                                        </a>
                                        <ul class="lang_sub_list">
                                            <li v-for="currency in globals.currencies" :key="currency.code">
                                                <a href="#" @click.prevent="setCurrency(currency.code)">
                                                    <span>{{ currency.symbol }}</span>
                                                    {{ currency.name }}
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
</template>

<script setup>
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';
import { useGlobalsStore } from '../stores/globals';
import SmartLink from './SmartLink.vue';

const auth = useAuthStore();
const globals = useGlobalsStore();
const router = useRouter();

const asset = (path) => `/${path.replace(/^\/+/, '')}`;

async function handleLogout() {
    await auth.logout();
    router.push({ name: 'home' });
}

function setLanguage(code) {
    document.cookie = `language=${code}; path=/; max-age=${60 * 60 * 24 * 30}`;
    window.location.reload();
}

function setCurrency(code) {
    document.cookie = `currency=${code}; path=/; max-age=${60 * 60 * 24 * 30}`;
    window.location.reload();
}
</script>
