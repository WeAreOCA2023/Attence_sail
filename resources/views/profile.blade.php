@extends('layouts.fixed')

@section('content')
<div class="profile d-column justify-content-center h-100 w-100 mx-auto py-4">
    <div class="upperBox d-flex">
        <div class="upperLeftBox">
            <div class="icon">
                <h3>Anderson Jennifer</h3>
            </div>
        </div>
        <div class="upperRightBox d-column">
            <div class="upperRightTopBox">
                <h2>個人設定</h2>
            </div>
            <div class="upperRightMiddleBox">
                <h2>会社情報</h2>
            </div>
            <div class="upperRightBottomBox">
                <h2>タスク情報</h2>
            </div>
        </div>
    </div>
    <div class="lowerBox d-flex">
        <div class="low">
            <div class="title">
                <h2>契約情報</h2>
                <form action="{{ route('profile.store') }}" method="POST">
                    @csrf
                    <div class="agreement36">
                        <label for="companyName">{{ __('36協定') }}</label>
                        <select class="form-select" aria-label="Agreement 36" name="agreement36">
                            <option selected value="unset">未選択</option>
                            <option value="agreed">有り</option>
                            <option value="special">特別条項付き36協定</option>
                            <option value="declined">無し</option>
                        </select>
                        @error('agreement36')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="variableWorkingHoursSystem">
                        <label for="variableWorkingHoursSystem">{{ __('変形時間労働制') }}</label>
                        <select class="form-select" aria-label="Variable Working Hours System" name="variableWorkingHoursSystem">
                            <option selected value="unset">未選択</option>
                            <option value="agreed">有り</option>
                            <option value="declined">無し</option>
                        </select>
                    </div>
                    <div class="RegisterButton">
                        <button type="submit">
                            {{ __('保存') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @can('boss')
        <div class="company">
            <div class="title">
                <h2>会社情報</h2>
            </div>
            <form action="{{ route('profile.store2') }}" method="POST">
                @csrf
                <div class="companyName">
                    <label for="companyName">{{ __('会社名') }}</label>
                    <input id="companyName" type="text" name="companyName" value="{{ old('companyName') }}" required autocomplete="companyName">
                </div>
                <div class="companyPostCode">
                    <label for="companyPostCode">{{ __('会社の郵便番号') }}</label>
                    <input id="companyPostCode" type="text" name="companyPostCode" value="{{ old('companyPostCode') }}"  required autocomplete="companyPostCode" minlength=7 maxlength=7>
                </div>
                <div class="companyAddress">
                    <label for="companyAddress">{{ __('会社の住所') }}</label>
                    <input id="companyAddress" type="text" name="companyAddress" value="{{ old('companyAddress') }}"  required autocomplete="companyAddress">
                </div>
                <div class="saveButton">
                    <button type="submit">
                        {{ __('保存') }}
                    </button>
                </div>
            </form>
        </div>
        @endcan
    </div>

</div>
@endsection