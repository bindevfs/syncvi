<template>
  <vx-card class="mt-12" id="comment">
    <div class="comments-container mt-4">
      <h4 class="mb-3">{{ $t('orders.custom_comment') }}</h4>
      <ul class="user-comments-list">
        <li class="commented-user flex items-center mb-4" v-for="comment in this.getComments" :key="comment.id">
          <div class="mr-3"><vs-avatar class="m-0" :src="comment.type === 0 ? require('@/assets/images/avatar/customer.png') : require('@/assets/images/avatar/shop.png')" size="50px" /></div>
          <div class="leading-tight">
            <span class="font-medium text-primary">{{ comment.type === 0 ? getUser.name : 'SHOP' }}</span>
            <span class="text-base">{{ comment.content }}</span>
            <span class="block mt-2">{{ comment.created_at | date(true) }} at {{ comment.created_at | time }}</span>
          </div>
        </li>
      </ul>
    </div>
    <div class="post-comment">
      <vs-textarea
        :placeholder="$t('orders.add_comment')"
        v-model="comment"
        class="mb-2"
        v-validate="'required|min:1'"
        data-vv-validate-on="blur"
        name="comment"
      />
      <span class="text-danger text-sm block mb-2">{{ errors.first('comment') }}</span>
      <vs-button size="medium" @click="commentOrder" :disabled="!validateForm">{{ $t('orders.post_comment') }}</vs-button>
    </div>
  </vx-card>
</template>
<script>
import { mapGetters, mapActions } from 'vuex'
import { Validator } from 'vee-validate'
import CODE from '@/configs/code'
import NProgress from 'nprogress'

Validator.localize({
  en: {
    messages: {
      required: (field) => field + ' không được để trống.'
    }
  }
})

export default {
  props: ['order'],
  data () {
    return {
      comment: ''
    }
  },
  computed: {
    ...mapGetters(['getUser', 'getComments']),
    validateForm () {
      return this.comment
    }
  },
  mounted () {
    this.comments(this.order.id)
  },
  methods: {
    ...mapActions(['commentAction', 'comments']),
    commentOrder () {
      let params = {
        order_id: this.order.id,
        content: this.comment
      }
      NProgress.start()
      this.commentAction(params).then(response => {
        if (response.code === CODE.SUCCESS) {
          this.$store.commit('NOTIFICATION_SUCCESS', {
            title: `Thông Báo`,
            message: `Nhận xét thành công.`
          })
          this.$store.commit('SET_COMMENT', response.data.comment)
        } else {
          this.$store.commit('NOTIFICATION_ERROR', {
            title: `Thông Báo`,
            message: `Bạn không thể nhận xét.`
          })
        }
        this.comment = null
        NProgress.done()
      }).catch(() => {
        NProgress.done()
      })
    }
  }
}
</script>
<style lang="scss" scoped>
  #comment {
    .con-vs-avatar {
      background: #fff !important;
    }
    .vs-textarea {
      height: 150px;
    }
  }
</style>
