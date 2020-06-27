const formatPrice = {
  methods: {
    formatPriceProduct (value) {
      let val = (value / 1).toFixed().replace('.', ',')
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')
    }
  }
}

export default formatPrice
