<template>
  <div id="guide-questions">
    <div id="content-area" class="content-area-reduced">
      <div id="content-overlay"></div>
      <div class="content-wrapper-full">
        <nav-bar />
      </div>
    </div>
    <div class="mb-12 background__questions">
      <div class="vx-row">
        <div class="vx-col lg:w-8/12 mr-auto ml-auto">
          <div class="content-area__heading pr-4 border-0 border-t-0 border-b-0 border-l-0 border-solid border-grey-light">
          </div>
        </div>
      </div>
    </div>
    <div class="mb-12 mt-12">
      <div class="vx-row">
        <div class="vx-col lg:w-8/12 mr-auto ml-auto">
          <div class="content-area__heading pr-4 border-0 border-t-0 border-b-0 border-l-0 border-solid border-grey-light">
            <h3 class="font-bold text-center mb-12 text-primary">Các Câu Hỏi Thường Gặp</h3>
            <div class="vx-col w-full md:w-3/5 lg:w-3/4 mt-12 md:mt-0 mr-auto ml-auto">
              <vs-collapse accordion type="margin" class="p-0">
                <vs-collapse-item class="faq-bg rounded-lg" v-for="faq in this.getFaqs" :key="faq.id">
                  <div slot="header"><h3>{{ faq.question }}</h3></div>
                  <p v-html="faq.answer"></p>
                </vs-collapse-item>
              </vs-collapse>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import NavBar from '@/components/NavBar'
import { mapGetters } from 'vuex'

export default {
  components: {
    NavBar
  },
  computed: {
    ...mapGetters(['getFaqs'])
  }
}
</script>
<style lang="scss">
  #guide-questions {
    .background__questions {
      background: url("../../../assets/images/guide/question.png") top center no-repeat fixed;
      display: block;
      position: relative;
      width: 100%;
      height: 0;
      padding-bottom: 20%;
      background-size: 100%;
    }
  }
</style>
