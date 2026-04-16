<template>
    <div>
        <DirectionSearchForm />

        <!-- visa type start -->
        <section class="visa type pb-135 mt-50">
            <div class="container">
                <div class="service-wrap pos-rel">
                    <div class="service-img-wrap">
                        <div class="service-bg"></div>
                        <div class="service-img" v-reveal:skew="{ delay: 100 }"
                            :style="{ backgroundImage: `url(${asset('user/assets/img/service/img_01.jpg')})` }"></div>
                    </div>
                    <div class="sec-title pt-120" v-reveal:skew>
                        <h2 class="mb-60">Visa types and eligibility <br> <span>assessment</span></h2>
                    </div>
                    <div class="row justify-content-md-center mt-none-30">
                        <div v-for="(visa, i) in visaTypes" :key="i" class="col-lg-4 col-md-6 mt-30"
                            v-reveal:up="{ delay: 80 * i }">
                            <div class="xb-service">
                                <div class="xb-item--inner">
                                    <div :class="['xb-item--icon', 'mb-50', visa.colorClass]">
                                        <img :src="asset(visa.icon)" alt="">
                                    </div>
                                    <div class="xb-item--holder">
                                        <h3 class="xb-item--title mb-20">
                                            <span class="text-dark">{{ visa.title }}</span>
                                        </h3>
                                        <div class="xb-item--description">{{ visa.description }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- about start -->
        <section class="about pos-rel pb-130">
            <div class="container">
                <div class="sec-title mb-55" v-reveal:skew>
                    <h2 class="mb-30">
                        Dependable and Trustworthy Visa & <br>
                        <span>Immigration Guidance</span>
                    </h2>
                    <p>Our team of seasoned professionals understands the <br>
                        complexities of immigration laws and visa procedures.</p>
                </div>
                <div class="row align-items-center">
                    <div class="col-lg-10">
                        <div class="about__content">
                            <ul class="about-list ul_li list-unstyled">
                                <li v-for="(step, i) in steps" :key="i" v-reveal:up="{ delay: 100 * i }">
                                    <div class="xb-item--inner">
                                        <div :class="['xb-item--number', step.colorClass]">{{ i + 1 }}</div>
                                        <div class="xb-item--holder">
                                            <h3 class="xb-item--title mb-10">{{ step.title }}</h3>
                                            <div class="xb-item--description">{{ step.description }}</div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="about__img" v-reveal:right>
                <img :src="asset('user/assets/img/about/about_img.png')" alt="">
            </div>
        </section>

        <!-- counter start -->
        <section class="counter pt-120 pb-120 bg_img"
            :style="{ backgroundImage: `url(${asset('user/assets/img/bg/counter_bg.jpg')})` }">
            <div class="container">
                <div class="sec-title mb-45" v-reveal:skew>
                    <h2 class="mb-40">
                        Discovering Our Biggest Successes: The Stories <br>
                        <span> Behind Our Great Achievements</span>
                    </h2>
                    <p>Embarking on a journey to reunite families, we recently had the privilege of assisting a <br>
                        couple in securing their spouse's visa.</p>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="xb-counter ul_li">
                            <div v-for="(counter, i) in counters" :key="i"
                                :class="['xb-item--item', counter.styleClass, 'ul_li']"
                                v-reveal:up="{ delay: 120 * i }">
                                <div class="xb-item--icon">
                                    <img :src="asset(counter.icon)" alt="">
                                </div>
                                <div class="xb-item--holder">
                                    <h2 class="xb-item--number">
                                        <AnimatedCounter :target="counter.count" />
                                        <span class="suffix">{{ counter.suffix }}</span>
                                    </h2>
                                    <h5 class="xb-item--title">{{ counter.title }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- faq start -->
        <section class="faq pt-120 pb-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="xb-faq-content" v-reveal:left>
                            <div class="sec-title mb-125">
                                <h2 class="mb-30">Common questions <br> <span> answered</span></h2>
                                <p>At the heart of our commitment to providing <br>
                                    exceptional immigration solutions stands our trusted</p>
                            </div>
                            <div class="faq-img">
                                <img :src="asset('user/assets/img/faq/faq_img.png')" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="xb-faq">
                            <ul class="accordion_box clearfix">
                                <li v-for="(faq, i) in faqs" :key="i"
                                    :class="['accordion block', { 'active-block': openFaq === i }]"
                                    v-reveal:right="{ delay: 80 * i }">
                                    <div class="acc-btn" @click="toggleFaq(i)" style="cursor: pointer;">
                                        {{ faq.question }}
                                        <span class="arrow"></span>
                                    </div>
                                    <transition name="faq-slide"
                                        @before-enter="collapseBeforeEnter"
                                        @enter="collapseEnter"
                                        @after-enter="collapseAfterEnter"
                                        @before-leave="collapseBeforeLeave"
                                        @leave="collapseLeave">
                                        <div v-if="openFaq === i" class="acc_body current">
                                            <div class="content">
                                                <p v-html="faq.answer"></p>
                                                <ul v-if="faq.bullets">
                                                    <li v-for="(b, j) in faq.bullets" :key="j">
                                                        <i class="far fa-check"></i>{{ b }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </transition>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import DirectionSearchForm from '../components/DirectionSearchForm.vue';
import AnimatedCounter from '../components/AnimatedCounter.vue';

const asset = (path) => `/${path.replace(/^\/+/, '')}`;

const visaTypes = [
    { title: 'Tourist Visa', icon: 'user/assets/img/icon/sv_01.svg', colorClass: '',
      description: 'Visit new places to discover with a Tourist Visa. We deliver your documents ...' },
    { title: 'Commercial Visa', icon: 'user/assets/img/icon/sv_02.svg', colorClass: 'color2',
      description: 'Developing your trade, setting up new sales channels Your visa is ready...' },
    { title: 'Student Visa', icon: 'user/assets/img/icon/sv_03.svg', colorClass: 'color3',
      description: 'Embarking on a journey of higher education in a foreign country opens doors to...' },
    { title: 'Residence Visa', icon: 'user/assets/img/icon/sv_04.svg', colorClass: 'color4',
      description: 'Expert Guidance for a Seamless Immigration Journey Expert Guidance...' },
    { title: 'Working Visa', icon: 'user/assets/img/icon/sv_05.svg', colorClass: 'color5',
      description: 'Get your Visa now for new business and earning opportunities. We deliver your...' },
];

const steps = [
    { title: 'Choose your visa type', description: 'Determine the Visa type for your travel purpose.', colorClass: '' },
    { title: 'Contact our branches', description: 'Start your transaction by applying to our branches.', colorClass: 'color-2' },
    { title: 'Submit All Your Documents', description: 'Collect all the required documents the process.', colorClass: 'color-3' },
    { title: 'Passport delivery', description: 'Receive your visa, which is finalized after application,', colorClass: 'color-4' },
];

const counters = [
    { icon: 'user/assets/img/icon/c_01.svg', count: 20, suffix: '+', title: 'Visa Categories', styleClass: '' },
    { icon: 'user/assets/img/icon/c_02.svg', count: 30, suffix: 'K+', title: 'Visa Process', styleClass: 'style-2' },
    { icon: 'user/assets/img/icon/c_03.svg', count: 40, suffix: 'K+', title: 'Successful Project', styleClass: 'style-3' },
    { icon: 'user/assets/img/icon/c_04.svg', count: 180, suffix: 'K+', title: 'Pro Consultants', styleClass: 'style-4' },
];

const faqs = [
    {
        question: 'What services do you offer?',
        answer: 'We offer comprehensive immigration and visa consulting services, <br> including visa application assistance, document preparation,',
        bullets: ['Comprehensive Visa Assistance', 'Visa Category Expertise', 'Transparency and Communication'],
    },
    {
        question: 'How long does the visa process usually take?',
        answer: 'Processing time depends on the destination and visa category. Our standard <br> turnaround is between 3 and 14 business days once all documents are received.',
    },
    {
        question: 'What documents will I need to provide?',
        answer: 'At a minimum you\'ll need a valid passport, recent photo, and proof of the <br> purpose of your trip. We provide a tailored checklist once you begin an application.',
    },
    {
        question: 'Do you offer refunds if my visa is denied?',
        answer: 'Service fees are non-refundable, but our specialists review every case before <br> submission to minimise the risk of refusal.',
    },
];

const openFaq = ref(0);
function toggleFaq(i) {
    openFaq.value = openFaq.value === i ? -1 : i;
}

// Smooth accordion height transition using JS hooks.
function collapseBeforeEnter(el) {
    el.style.height = '0';
    el.style.overflow = 'hidden';
    el.style.transition = 'height 300ms ease';
}
function collapseEnter(el) {
    // Force layout, then animate to scrollHeight.
    requestAnimationFrame(() => {
        el.style.height = `${el.scrollHeight}px`;
    });
}
function collapseAfterEnter(el) {
    el.style.height = '';
    el.style.overflow = '';
    el.style.transition = '';
}
function collapseBeforeLeave(el) {
    el.style.height = `${el.scrollHeight}px`;
    el.style.overflow = 'hidden';
    el.style.transition = 'height 300ms ease';
}
function collapseLeave(el) {
    requestAnimationFrame(() => {
        el.style.height = '0';
    });
}
</script>
