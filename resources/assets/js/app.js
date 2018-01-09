const { initMap } = require('./map')
const { trackOutboundLink } = require('./analytics')

window.initMap = initMap // export this function so the google maps api script can call it when loaded
window.trackOutboundLink = trackOutboundLink
