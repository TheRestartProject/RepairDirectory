const { search, loadBusiness } = require('./map')
const { trackOutboundLink } = require('./analytics')

window.search = search // export this function so the google maps api script can call it when loaded
window.loadBusiness = loadBusiness // export this function so the google maps api script can call it when loaded
window.trackOutboundLink = trackOutboundLink
