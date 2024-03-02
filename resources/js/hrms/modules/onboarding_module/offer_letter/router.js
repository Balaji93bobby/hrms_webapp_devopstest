import { createRouter, createWebHistory } from 'vue-router'
import offer_master from './offer_letter_master/offer_letter_master.vue'
import offer_completed from './offer_letter_master/offer_letter_completed/OfferLetterCompleted.vue'
import offer_pending from './offer_letter_master/offer_letter_pending/OfferLetterPending.vue'
import offer_resent  from './offer_letter_master/offer_letter_resent/OfferLetterResent.vue'
import offer_letter_generation from './offer_letter_generation/offer_letter_generation.vue'
import offer_letter_template from './offer_letter_template/offer_letter_template.vue'
const routes = [
  {
    path: '/offer',
    name: 'offer_master',
    component: offer_master
  },
  {
    path: '/offer_completed',
    name: 'offer_completed',
    component: offer_completed
  },
  {
    path: '/offer_pending',
    name: 'offer_pending',
    component: offer_pending
  },
  {
    path: '/offer_resent',
    name: 'offer_resent',
    component: offer_resent
  },
  {
    path: '/offer_letter_generation',
    name: 'offer_letter_generation',
    component: offer_letter_generation
  },
  {
    path: '/offer_letter_template',
    name: 'offer_letter_template',
    component: offer_letter_template
  },

]
const router = createRouter({
    history: createWebHistory(),
  routes
})
export default router
