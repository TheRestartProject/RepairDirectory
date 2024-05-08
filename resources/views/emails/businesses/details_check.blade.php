<h2>Check business details</h2>

<ul>
    <li><strong>{{ __('admin.name') }}:</strong>  {{ $business->getName() }}</li>
    <li><strong>{{ __('admin.address') }}:</strong> {{ $business->getAddress() }}</li>
    <li><strong>{{ __('admin.postcode') }}:</strong> {{ $business->getPostcode() }}</li>
    <li><strong>{{ __('admin.local_area') }}:</strong> {{ $business->getLocalAreaName() }}</li>
    <li><strong>{{ __('admin.categories') }}:</strong> {{ implode(', ', $business->getCategories()) }}</li>
    <li><strong>{{ __('admin.review_count') }}:</strong> {{ $business->getNumberOfReviews() }}</li>
    <li><strong>{{ __('admin.review_percent') }}:</strong> {{ $business->getPositiveReviewPc() }}</li>
    <li><strong>{{ __('admin.publishing_status') }}:</strong> {{ $business->getPublishingStatus() }}</li>
    <li><strong>Notes:</strong> {{ $business->getNotes() }}</li>
    <li><strong>{{ __('admin.hide_reason') }}:</strong> {{ $business->getHideReason() }}</li>
</ul>

<div>
    Please reply to this email with any amendments needed.
</div>

