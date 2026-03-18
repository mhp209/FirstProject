<div class="row">

    <div class="col-lg-12">
        <div class="promo-code-box">
            <input type="text" placeholder="Promo code" id='promo-code'>
            <a class="btn-apply" id='apply-code-btn'>Apply</a>
            <div id="code-error" class="error invalid-feedback" style="display: none;"></div>
        </div>
        @if(count($Promocode) > 0)
            <hr>
        @endif
    </div>

   @foreach($Promocode as $code)
        @if(($applied_code != $code->code))
            @if($code->valid)
                <div class="col-lg-12">
                    <div class="coupon-card">
                        <div class="coupon-row">
                            <span class="cpnCode">{{ $code->code }}</span>
                            <button class="apply-btn apply-promo-code" data-id="{{ $code->id }}" data-code="{{ $code->code }}">apply</button>
                        </div>
                        <div class="content">
                            <ul>
                                <li>{{ $code->description }}</li>
                            </ul>
                        </div>
                        <div class="circle1"></div>
                        <div class="circle2"></div>
                    </div>
                </div>
            @else
                <div class="col-lg-12">
                    <div class="coupon-card-two">
                        <div class="coupon-row">
                            <span class="cpnCode">{{ $code->code }}</span>
                            <button class="apply-btn">apply</button>
                        </div>
                        <div class="content">
                            <ul>
                                <li>{{ $code->description }}</li>
                            </ul>
                        </div>
                        <div class="circle1"></div>
                        <div class="circle2"></div>
                    </div>
                </div>
            @endif
        @endif
   @endforeach


</div>
