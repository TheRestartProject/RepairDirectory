<html>
<body>

    <div id="email_wrapper" style="font-family: Arial, Helvetica, sans-serif;">

        <h2>Review your details</h2>

        <div id="email_content" style="width: 50vw; max-width: 900px;">

            <p>
                Hi there,
            </p>
            <p>
                Your organisation, {{ $business->getName() }}, is listed on The Restart Project's <a 
                href="https://therestartproject.org/where-to-donate-your-computer/" target="_blank">directory of computer reuse 
                organisations</a>.
            </p>
            <p>
                To keep the directory up-to-date and effective, this is a quick regular e-mail just to check that we have 
                the correct details about your organisation.
            </p>
            <p>
                Please have a look over the information below. If there's anything you would like corrected or amended, just hit 
                "Reply" and let us know - all changes will be handled by a real person, so you don't need to log-in or fill in 
                any forms.
            </p>

            <div id="details">
                <ul style="line-height: 2em">
                    <li><strong>{{ __('admin.name') }}:</strong>  {{ $business->getName() }}</li>
                    <li><strong>{{ __('admin.address') }}:</strong> {{ $business->getAddress() }}</li>
                    <li><strong>{{ __('admin.postcode') }}:</strong> {{ $business->getPostcode() }}</li>
                    <li><strong>{{ __('admin.description') }}:</strong> {{ $business->getDescription() }}</li>
                    <li><strong>{{ __('admin.phone') }}:</strong> {{ $business->getLandline() }}</li>
                    <li><strong>{{ __('admin.mobile') }}:</strong> {{ $business->getMobile() }}</li>
                    <li><strong>{{ __('admin.website') }}:</strong> {!! $business->getWebsite(true) !!}</li>
                    <li><strong>{{ __('admin.email') }}:</strong> {{ $business->getEmail() }}</li>
                    <li><strong>{{ __('admin.categories') }}:</strong> {{ implode(', ', $business->getCategories()) }}</li>
                    <li><strong>{{ __('admin.qualifications') }}:</strong> {!! $business->getQualifications(true) !!}</li>
                    <li><strong>{{ __('admin.community_endorsement') }}:</strong> {{ $business->getCommunityEndorsement() }}</li>
                    <li><strong>{{ __('admin.custom_field1') }}:</strong> {!! $business->getCustomField1(true) !!}</li>
                    <li><strong>{{ __('admin.custom_field2') }}:</strong> {!! $business->getCustomField2(true) !!}</li>
                    <li><strong>{{ __('admin.custom_field3') }}:</strong> {!! $business->getCustomField3(true) !!}</li>
                    <li><strong>{{ __('admin.warranty_offered') }}:</strong> {{ $business->isWarrantyOffered() }}</li>
                    <li><strong>{{ __('admin.warranty_details') }}:</strong> {!! $business->getWarranty(true) !!}</li>
                </ul>
            </div>

            <p>
                Many thanks,<br />
                The Restart Project team.<br />
                <img src="https://therestartproject.org/wp-content/themes/restart/images/logo-wordmark.svg" alt="The Restart Project logo" 
                     style="width: 150px; margin-top: 1em" />
            </p>
        </div>
        <div id="email_footer" style="font-size: smaller; width: 50vw; max-width: 900px; padding-top: 1em;">
            <hr />
            You are receiving this email as your organisation is listed on The Restart Project's <a 
            href="https://therestartproject.org/where-to-donate-your-computer/" target="_blank">directory of computer reuse 
            organisations</a>.  If you would like to stop receiving these emails, please <a 
            href="mailto:{{ env('MAIL_BUSINESSCHECK_REPLYTO_MAIL') }}?subject=Reuse Directory reminder: unsubscribe">reply</a> 
            with the subject 'Reuse Directory reminder: unsubscribe'.
        </div>

    </div>

</body>
</html>