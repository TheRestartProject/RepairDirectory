/**
 * Function that tracks a click on an outbound link in Analytics.
 * This function takes a valid URL string as an argument, and uses that URL string
 * as the event label. Setting the transport method to 'beacon' lets the hit be sent
 * using 'navigator.sendBeacon' in browser that support it.
 */
const trackOutboundLink = function (url) {
  window.ga('send', 'event', 'outbound', 'click', url, {
    'transport': 'beacon',
    'hitCallback': function () { document.location = url }
  })
}

module.exports = { trackOutboundLink }
