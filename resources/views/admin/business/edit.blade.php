@extends('admin.layout')

@section('content')
    <h2>{{ $isCreate ? 'New' : 'Edit' }} Business</h2>

    <form class="row" action="{{ $formAction }}" method="post">

        {{ csrf_field() }}

        {{ method_field($formMethod) }}

        <div class="col-xs-12 col-md-4">
            <div class="form-group">
                <label for="name">Name</label>
                <input id="name" name="name" class="form-control" value="{{ $business->getName() }}"/>
                {!! array_key_exists('name', $errors) ? '<small>' . $errors['name'] . '</small>' : '' !!}
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input id="address" name="address" class="form-control" value="{{ $business->getAddress() }}"/>
                {!! array_key_exists('address', $errors) ? '<small>' . $errors['address'] . '</small>' : '' !!}
            </div>

            <div class="form-group">
                <label for="postcode">Postcode</label>
                <input id="postcode" name="postcode" class="form-control" value="{{ $business->getPostcode() }}"/>
                {!! array_key_exists('postcode', $errors) ? '<small>' . $errors['postcode'] . '</small>' : '' !!}
            </div>

            <div class="form-group">
                <label for="city">City</label>
                <input id="city" name="city" class="form-control" value="{{ $business->getCity() }}"/>
                {!! array_key_exists('city', $errors) ? '<small>' . $errors['city'] . '</small>' : '' !!}
            </div>

            <div class="form-group">
                <label for="localArea">Borough / Local Area</label>
                <input id="localArea" name="localArea" class="form-control" value="{{ $business->getLocalArea() }}">
                {!! array_key_exists('localArea', $errors) ? '<small>' . $errors['localArea'] . '</small>' : '' !!}
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control">{{ $business->getDescription() }}</textarea>
                {!! array_key_exists('description', $errors) ? '<small>' . $errors['description'] . '</small>' : '' !!}
            </div>

            <div class="form-group">
                <label for="landline">Landline</label>
                <input id="landline" name="landline" class="form-control" value="{{ $business->getLandline() }}">
                {!! array_key_exists('landline', $errors) ? '<small>' . $errors['landline'] . '</small>' : '' !!}
            </div>

            <div class="form-group">
                <label for="mobile">Mobile</label>
                <input id="mobile" name="mobile" class="form-control" value="{{ $business->getMobile() }}">
                {!! array_key_exists('mobile', $errors) ? '<small>' . $errors['mobile'] . '</small>' : '' !!}
            </div>

            <div class="form-group">
                <label for="website">Website</label>
                <input id="website" name="website" class="form-control" value="{{ $business->getWebsite() }}">
                {!! array_key_exists('website', $errors) ? '<small>' . $errors['website'] . '</small>' : '' !!}
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" name="email" class="form-control" value="{{ $business->getEmail() }}">
                {!! array_key_exists('email', $errors) ? '<small>' . $errors['email'] . '</small>' : '' !!}
            </div>
        </div>

        <div class="col-xs-12 col-md-4">
            <div class="form-group">
                <label for="categories">Categories</label>
                <select id="categories" name="categories[]" class="form-control" multiple>
                    @foreach($categories as $category)
                        <option value="{{ $category }}"
                                {{ in_array($category->getValue(), $business->getCategories()) ? "selected" : "" }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
                {!! array_key_exists('categories', $errors) ? '<small>' . $errors['categories'] . '</small>' : '' !!}
            </div>

            <div class="form-group">
                <label for="productsRepaired">Products Repaired</label>
                <input id="productsRepaired" name="productsRepaired" class="form-control"
                       value="{{ implode(', ', $business->getProductsRepaired()) }}">
                {!! array_key_exists('productsRepaired', $errors) ? '<small>' . $errors['productsRepaired'] . '</small>' : '' !!}
            </div>

            <div class="form-group">
                <label for="authorisedBrands">Authorised Brands</label>
                <input id="authorisedBrands" name="authorisedBrands" class="form-control"
                       value="{{ implode(', ', $business->getAuthorisedBrands()) }}">
                {!! array_key_exists('authorisedBrands', $errors) ? '<small>' . $errors['authorisedBrands'] . '</small>' : '' !!}
            </div>

            <div class="form-group">
                <label for="qualifications">Qualifications</label>
                <textarea id="qualifications" name="qualifications" class="form-control">{{ $business->getQualifications() }}</textarea>
                {!! array_key_exists('qualifications', $errors) ? '<small>' . $errors['qualifications'] . '</small>' : '' !!}
            </div>

            <div class="form-group">
                <label for="communityEndorsement">Community Endorsement</label>
                <textarea id="communityEndorsement" name="communityEndorsement" class="form-control">{{ $business->getCommunityEndorsement() }}</textarea>
                {!! array_key_exists('communityEndorsement', $errors) ? '<small>' . $errors['communityEndorsement'] . '</small>' : '' !!}
            </div>

            <div class="form-group">
                <label for="notes">Notes</label>
                <textarea id="notes" name="notes" class="form-control">{{ $business->getNotes() }}</textarea>
                {!! array_key_exists('notes', $errors) ? '<small>' . $errors['notes'] . '</small>' : '' !!}
            </div>
        </div>

        <div class="col-xs-12 col-md-4">
            <div class="form-group">
                <label for="positiveReviewPcRange">Positive Review Percentage</label>
                <input id="positiveReviewPcRange" name="positiveReviewPcRange" type="range" class="slider" min="0" max="100" value={{$business->getPositiveReviewPc()}}>
                <input id="positiveReviewPc" name="positiveReviewPc" type="number" class="form-control slider-input" value={{$business->getPositiveReviewPc()}}>
                <span>%</span>
                {!! array_key_exists('positiveReviewPc', $errors) ? '<small>' . $errors['positiveReviewPc'] . '</small>' : '' !!}
            </div>

            <div class="form-group">
                <label for="reviewSource">Review Source</label>
                <select id="reviewSource" name="reviewSource" class="form-control">
                    @foreach($reviewSources as $source)
                        <option value="{{ $source }}" {{ $business->getReviewSource() == $source ? "selected" : "" }}>
                            {{ $source }}
                        </option>
                    @endforeach
                </select>
                {!! array_key_exists('reviewSource', $errors) ? '<small>' . $errors['reviewSource'] . '</small>' : '' !!}
            </div>

            <div class="form-group">
                <label for="numberOfReviews">Number of Reviews</label>
                <input id="numberOfReviews" name="numberOfReviews" class="form-control" value="{{$business->getNumberOfReviews()}}">
                {!! array_key_exists('numberOfReviews', $errors) ? '<small>' . $errors['numberOfReviews'] . '</small>' : '' !!}
            </div>

            <div class="form-group">
                <label for="averageScore">Average Score</label>
                <input id="averageScore" name="averageScore" class="form-control" value="{{$business->getAverageScore()}}">
                {!! array_key_exists('averageScore', $errors) ? '<small>' . $errors['averageScore'] . '</small>' : '' !!}
            </div>

            <div class="form-group">
                <label for="warrantyOffered">Warranty Offered</label>
                <input type="checkbox" name="warrantyOffered" id="warrantyOffered" class="form-control" {{$business->isWarrantyOffered() ? 'checked' : ''}} value="Yes" >
                {!! array_key_exists('warrantyOffered', $errors) ? '<small>' . $errors['warrantyOffered'] . '</small>' : '' !!}
            </div>
            
            <div class="form-group">
                <label for="warranty">Warranty Details</label>
                <textarea name="warranty" id="warranty" cols="30" rows="10" class="form-control">{{$business->getWarranty()}}</textarea>
                {!! array_key_exists('warranty', $errors) ? '<small>' . $errors['warranty'] . '</small>' : '' !!}
            </div>

            <div class="form-group">
                <label for="publishingStatus">Publishing Status</label>
                <select id="publishingStatus" name="publishingStatus" class="form-control">
                    @foreach($publishingStatuses as $status)
                        <option value="{{ $status }}" {{ $business->getPublishingStatus() == $status ? "selected" : "" }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
                {!! array_key_exists('publishingStatus', $errors) ? '<small>' . $errors['publishingStatus'] . '</small>' : '' !!}
            </div>

            <div>
                <button id="submit" class="btn btn-success">Save</button>
            </div>
            {!! array_key_exists('business', $errors) ? '<small>' . $errors['business'] . '</small>' : '' !!}
        </div>
    </form>
@endsection