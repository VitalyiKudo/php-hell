<div id="search">

    @forelse ($emptyLegs as $emptyLeg)
        {!! ((int)$emptyLeg['price'] !== 0) ?
        "<form action='" . route('client.orders.confirm') . "' method='GET'>"
        :
        "<form action='" . route('client.search.requestQuote') . "' method='GET'>"
        !!}
        @php
            $type = Str::after($emptyLeg['typePlane'], '_');
            $TYPE = Str::upper($type);
            $Type = Str::ucfirst($type);
        @endphp
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-inner-body pl-4">
                     <div class="type-info-legs">
                        <div class="type-price text-uppercase">
                            <span class="flight-type">{{__("$Type")}}</span>
                            <span style="font-size: 0.8rem;"><a href="/aircraft" title="{{__('ABOUT CLASS')}}">{{__('ABOUT CLASS')}}</a></span>
                        </div>
                        <div class="type-price">
                            <span class="flight-price">{{ $emptyLeg['dateDeparture']->format('d/m/Y') }}</span>
                            <span class="flight-price-desc"></span>
                        </div>
                        <div class="type-price-legs">
                            <span class="flight-price">{!! ((int)$emptyLeg['price'] !== 0) ? htmlspecialchars_decode('&#36; ', ENT_HTML5) . number_format($emptyLeg['price'], 2, '.', ' ') : 'Price on request.' !!}</span>
                            <span class="flight-price-desc">{{ ((int)$emptyLeg['price'] !== 0) ? __('Lowest Price (Incl. taxes)') : ''}}</span>
                        </div>

                        <div>
                            <span class="flight-price-desc">{{ __('From Airport')}}</span>
                            <span class="flight-price">{{ $emptyLeg['nameCityDeparture'] }}</span>
                        </div>
                        <div>
                            <span class="flight-price-desc">{{ __('To Airport')}}</span>
                            <span class="flight-price">{{ $emptyLeg['nameCityArrival'] }}</span>
                        </div>

                        <input type="hidden" name="result_id" value="{{ $emptyLeg['id'] }}">
                        <input type="hidden" name="aircraft" value="{{ $Type }}">
                        <input type="hidden" name="startPointName" value="{{ $emptyLeg['nameCityDeparture'] }}">
                        <input type="hidden" name="endPointName" value="{{ $emptyLeg['nameCityArrival'] }}">
                        <input type="hidden" name="startPoint" value="{{ $emptyLeg['geoNameIdCityDeparture'] }}">
                        <input type="hidden" name="endPoint" value="{{ $emptyLeg['geoNameIdCityArrival']}}">
                        <input type="hidden" name="startAirport" value="{{ $emptyLeg['icaoDeparture'] }}">
                        <input type="hidden" name="endAirport" value="{{ $emptyLeg['icaoArrival'] }}">
                        <input type="hidden" name="departure_at" value="{{ $emptyLeg['dateDeparture'] }}">
                        <input type="hidden" name="price" value="{{ $emptyLeg['price'] }}">
                        <input type="hidden" name="type" value="emptyLeg">
                        <input type="hidden" name="page_name" value="reqest-emptyLeg-page">

                        {!! ((int)$emptyLeg['price']!== 0) ?
                        "<div>
                            <button type='submit' class='price-empty-leg-submit'>" . __('Book now') . "</button>
                        </div>"
                        :
                        "<div>
                            <button type='submit' class='request-empty-leg-submit'>" . __('Request a Quote') . "</button>
                        </div>"
                        !!}
                    </div>
                </div>
            </div>
        </div>
        </form>
    @empty
        <div class="text-center">No matches found</div>
    @endforelse

    @if (!empty($emptyLegs) && $emptyLegs->hasPages())
        <div class="d-flex justify-content-center">
            {!! $emptyLegs->links() !!}
        </div>
    @endif
</div>
{{--}}
@push('scripts')
    <script>
    $(document).ready(function(){
            $('#pax').on("keyup change", function (e) {
                if($('#pax').val().length > 0) {
                    $('.search-error').remove();
                    e.preventDefault();
                }
            });

            $('.price-empty-leg-submit').on('click', function(e){
                //let passengers = $('#pax').val();
                let passengers = $('html, body').find('#pax').val();
                alert(passengers);
                let html_message = '<span class="search-error">This field is required.</span>';

                if(passengers.length <= 0){
                    $('.search-error').remove();
                    $('#pax').parent('div').append(html_message);
                    $('html, body').animate({
                        scrollTop: parseInt($('.search-error').offset().top)
                    }, 500);
                    $('#pax').focus();
                    e.preventDefault();
                }
                e.preventDefault();
            });
    });
    </script>
@endpush
--}}
