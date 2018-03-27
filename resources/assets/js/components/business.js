const $ = require('jquery')

/**
 * Render a business object as HTML
 *
 * @param business
 * @param compact If true, return HTML containing substantially less information
 */
module.exports = function (business, compact = false) {
  return `
      <div class="business">
          ${formatBusinessHeader(business, compact)}
          ${formatBusinessDetails(business, compact)}
      </div>
  `
}

function formatBusinessHeader (business, compact = false) {
  let $heading = $('<div class="business__heading"></div>')
  $heading.append(`<h2>${business.name}</h2>`)
  if (business.averageScore && !compact) {
    $heading.append(`
            <div class="hidden business__average-score">
                <h2>${business.averageScore} / 5</h2>
                <span>stars</span>
            </div>
        `)
  }
  if (business.positiveReviewPc) {
      reviewText = `
            <div class="business__positive-review-percentage">
                <h2>${business.positiveReviewPc}%</h2>
                <span>positive reviews</span>`;
      if (!compact && business.reviewSourceUrl) {
          reviewText += ` <a class="business__review-source-url" target="_blank" href="` + business.reviewSourceUrl + `">(source)</a>`;
      }
      reviewText += `
            </div>
      `;
      $heading.append(reviewText);
  }
  if (!compact) {
    $heading.append(`<p class="business__description">${business.description}</p>`)
  }
  return $heading[0].outerHTML
}

function formatBusinessDetails (business, compact = false) {
  let $details = $('<div class="business__details"></div>')

  if (!compact) {
    let $categories = $('<ul class="business__categories"></ul>')
    business.categories.forEach(category => {
      $categories.append(`<li>${category}</li>`)
    })
    $details.append($categories)
  }

  let $columns = $('<div class="row"></div>')
  let $leftColumn = $(`<div class="${compact ? 'col-xs-12' : 'col-xs-12 col-sm-6'}"></div>`)
  let $rightColumn = $(`<div class="${compact ? 'col-xs-12 business__extra-details' : 'col-xs-12 col-sm-6'}"></div>`)

  if (business.website) {
    const website = business.website.indexOf('http') === 0 ? business.website : ('http://' + business.website)
    $leftColumn.append(`
            <p class="business-detail">
                <span class="fa fa-globe"></span>
                <a target="_blank" href="${website}" onclick="trackOutboundLink('${website}');">
                    ${business.website}
                </a>
            </p>
        `)
  }

  if (business.email) {
    const href = `mailto:${business.email}`
    $leftColumn.append(`
            <p class="business-detail">
                <span class="fa fa-envelope-o"></span>
                <a href="${href}" onclick="trackOutboundLink('${href}';">
                    ${business.email}
                </a>
            </p>
        `)
  }

  if (business.landline || business.mobile) {
    const phoneNumber = business.landline || business.mobile
    const href = `tel:${phoneNumber}`
    $leftColumn.append(`
            <p class="business-detail">
                <span class="fa fa-phone"></span>
                <a href="${href}" onclick="trackOutboundLink('${href}');">
                    ${phoneNumber}
                </a>
            </p>
        `)
  }

  const completeAddress = [business.address, business.city, business.postcode]
        .filter(Boolean)
        .join(', ')

  $leftColumn.append(`
        <p class="business-detail">
            <span class="fa fa-map-marker"></span>
            <span>${completeAddress}</span>
        </p>
    `)

  $columns.append($leftColumn)

  if (business.warrantyOffered) {
    $rightColumn.append(`
            <p class="business-detail business-detail--scrollable">
                <span class="fa fa-calendar-check-o"></span>
                <span>Warranty: ${business.warranty || 'Provided'}</span>
            </p>
        `)
  }

  if (business.qualifications) {
    $rightColumn.append(`
            <p class="business-detail">
                <span class="fa fa-mortar-board"></span>
                <span>${business.qualifications}</span>
            </p>
        `)
  }

  $columns.append($rightColumn)

  $details.append($columns)

  if (business.communityEndorsement) {
    $details.append(`
            <div class="row business__extra-details">
                <div class="col-xs-12">
                    <p class="business-detail">
                        <span class="fa fa-comments"></span>
                        <span>Restart Community Endorsement:<br>${business.communityEndorsement}</span>
                    </p>
                </div>
            </div>
        `)
  }

  return $details[0].outerHTML
}
