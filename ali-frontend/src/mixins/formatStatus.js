const formatStatus = {
  methods: {
    customStatus (status) {
      let statusOrder = ''
      switch (status) {
        case 1:
          statusOrder = this.$t('status.processing')
          break
        case 2:
        case 3:
          statusOrder = this.$t('status.paid')
          break
        case 4:
          statusOrder = this.$t('status.ready')
          break
        case 5:
          statusOrder = this.$t('status.transported')
          break
        case 6:
          statusOrder = this.$t('status.successful_delivery')
          break
        case 7:
          statusOrder = this.$t('status.rejected')
          break
        case 8:
        case 9:
          statusOrder = this.$t('status.cancel')
          break
        default:
          break
      }
      return statusOrder
    }
  }
}

export default formatStatus
