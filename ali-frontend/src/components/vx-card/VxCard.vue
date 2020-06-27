<template>
    <div class="vx-card" ref="card" :class="[
        {'overflow-hidden': tempHidden},
        {'no-shadow': noShadow},
        {'rounded-none': noRadius},
        {'card-border': cardBorder} ]" :style="cardStyles">
        <div class="vx-card__header" v-if="hasHeader">

            <!-- card title -->
            <div class="vx-card__title">
                <h4 v-if="this.$props.title">{{ title }}</h4>
                <h6 v-if="this.$props.subtitle" class="text-grey">{{ subtitle }}</h6>
            </div>
        </div>

        <div class="vx-card__collapsible-content vs-con-loading__container" ref="content" :class="[{collapsed: isContentCollapsed}, {'overflow-hidden': tempHidden}]" :style="StyleItems">

            <slot name="no-body"></slot>

            <div class="vx-card__body" v-if="this.$slots.default">
                <slot></slot>
            </div>

            <slot name="no-body-bottom"></slot>

            <div class="vx-card__footer" v-if="this.$slots.footer">
                <slot name="footer"></slot>
            </div>
        </div>
    </div>
</template>

<script>
export default{
  name: 'vx-card',
  props: {
    title: String,
    subtitle: String,
    actionButtons: {
      type: Boolean,
      default: false
    },
    actionButtonsColor: {
      type: String,
      default: 'success'
    },
    codeToggler: {
      type: Boolean,
      default: false
    },
    noShadow: {
      default: false,
      type: Boolean
    },
    noRadius: {
      default: false,
      type: Boolean
    },
    cardBorder: {
      default: false,
      type: Boolean
    },
    codeLanguage: {
      default: 'markup',
      type: String
    },
    collapseAction: {
      default: false,
      type: Boolean
    },
    refreshContentAction: {
      default: false,
      type: Boolean
    },
    removeCardAction: {
      default: false,
      type: Boolean
    }
  },
  data () {
    return {
      isContentCollapsed: false,
      showCode: false,
      maxHeight: null,
      cardMaxHeight: null,
      codeContainerMaxHeight: '0px',
      tempHidden: false
    }
  },
  computed: {
    hasAction () {
      return this.$slots.actions || (this.actionButtons || this.collapseAction || this.refreshContentAction || this.removeCardAction || this.codeToggler)
    },
    hasHeader () {
      return this.hasAction || (this.title || this.subtitle)
    },
    StyleItems () {
      return { maxHeight: this.maxHeight }
    },
    cardStyles () {
      return { maxHeight: this.cardMaxHeight }
    },
    codeContainerStyles () {
      return { maxHeight: this.codeContainerMaxHeight }
    }
  }
}
</script>

<style lang="scss">
    @import "@/assets/scss/vuesax/components/vxCard.scss";
</style>
