<html>
<body>

    <div id="email_wrapper" style="font-family: Arial, Helvetica, sans-serif;">

        <h2>Review your details</h2>

        <div id="email_content" style="width: 50vw; max-width: 900px;">

            <p>
                Hi there, this is a quick regular e-mail just to check that we have the correct details about you.
            </p>
            <p>
                Please have a look over the information below. If there's anything you would like corrected or amended, 
                just hit "Reply" and let us know - all changes will be handled by a real person, so you don't need to 
                log-in or fill in any forms.
            </p>

            <div id="details">
                <ul>
                    <li><strong>{{ __('admin.name') }}:</strong>  {{ $business->getName() }}</li>
                    <li><strong>{{ __('admin.address') }}:</strong> {{ $business->getAddress() }}</li>
                    <li><strong>{{ __('admin.postcode') }}:</strong> {{ $business->getPostcode() }}</li>
                    <li><strong>{{ __('admin.description') }}:</strong> {{ $business->getDescription() }}</li>
                    <li><strong>{{ __('admin.phone') }}:</strong> {{ $business->getLandline() }}</li>
                    <li><strong>{{ __('admin.mobile') }}:</strong> {{ $business->getMobile() }}</li>
                    <li><strong>{{ __('admin.website') }}:</strong> {{ $business->getWebsite() }}</li>
                    <li><strong>{{ __('admin.email') }}:</strong> {{ $business->getEmail() }}</li>
                    <li><strong>{{ __('admin.categories') }}:</strong> {{ implode(', ', $business->getCategories()) }}</li>
                    <li><strong>{{ __('admin.qualifications') }}:</strong> {{ $business->getQualifications() }}</li>
                    <li><strong>{{ __('admin.community_endorsement') }}:</strong> {{ $business->getCommunityEndorsement() }}</li>
                    <li><strong>{{ __('admin.custom_field1') }}:</strong> {{ $business->getCustomField1() }}</li>
                    <li><strong>{{ __('admin.custom_field2') }}:</strong> {{ $business->getCustomField2() }}</li>
                    <li><strong>{{ __('admin.custom_field3') }}:</strong> {{ $business->getCustomField3() }}</li>
                    <li><strong>{{ __('admin.warranty_offered') }}:</strong> {{ $business->isWarrantyOffered() }}</li>
                    <li><strong>{{ __('admin.warranty_details') }}:</strong> {{ $business->getWarranty() }}</li>
                </ul>
            </div>

            <p>
                Many thanks,<br />
                The Restart Project team.
            </p>
        </div>
        <div id="email_footer" style="font-size: smaller;">
            Unsubscribe info and email sent from info.
        </div>

    </div>

</body>
</html>