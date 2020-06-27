import Vue from 'vue'

Vue.filter('date_time_format', function (value) {
  let date = new Date(value)
  let options = {
    year: 'numeric',
    month: 'numeric',
    day: 'numeric',
    hour: 'numeric',
    minute: 'numeric',
    second: 'numeric'
  }

  return new Intl.DateTimeFormat('it-IT', options).format(date)
})

Vue.filter('date_format', function (value) {
  let date = new Date(value)
  let options = {
    year: 'numeric',
    month: 'numeric',
    day: 'numeric'
  }

  return new Intl.DateTimeFormat('it-IT', options).format(date)
})

Vue.filter('price_format', function (value) {
  let val = (value / 1).toFixed().replace('.', ',')
  return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')
})

Vue.filter('time', function (value, is24HrFormat = false) {
  if (value) {
    const date = new Date(Date.parse(value))
    let hours = date.getHours()
    const min = (date.getMinutes() < 10 ? '0' : '') + date.getMinutes()
    if (!is24HrFormat) {
      const time = hours > 12 ? 'AM' : 'PM'
      hours = hours % 12 || 12
      return hours + ':' + min + ' ' + time
    }
    return hours + ':' + min
  }
})

Vue.filter('date', function (value, fullDate = false) {
  value = String(value)
  const date = value.slice(8, 10).trim()
  const month = value.slice(5, 7).trim()
  const year = value.slice(0, 4)

  if (!fullDate) return date + ' - ' + month
  else return date + ' - ' + month + ' - ' + year
})
