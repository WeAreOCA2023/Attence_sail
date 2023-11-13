@extends('layouts.fixed')

@section('content')
<div class="profile d-flex flex-column justify-content-start h-100 mx-auto py-4">
    <div class="upperBox d-flex">
        <div class="upperLeftBox d-flex flex-column items-center text-center justify-content-center">
            <img class="mx-auto" src="{{ asset('img/profileIcon.svg') }}" alt="Profile Icon">
            <h3>Anderson Jennifer</h3>
            <div class="creditScore d-flex flex-column w-fit-content">
                <label class="text-left" for="creditScore">信頼スコア</label>
                <progress class="mx-auto" id="creditScore" value="88" max="100">88%</progress>
            </div>
        </div>
        <div class="upperRightBox d-flex flex-column">
            <div class="upperRightTopBox">
                <div class="d-flex align-items-center mb-4">
                    <img  class="align-top" src="{{ asset('img/user-setting.svg') }}" alt="User Setting Icon">
                    <h2 class="m-0">個人設定</h2>
                </div>
                <div class="d-flex justify-content-around">
                    <div class="email">
                        <h3>Eメール:<input type="email" value="{{ Auth::user()->email }}" disabled></h3>
                    </div>
                    <div class="phoneNumber">
                        <h3>電話番号:<input type="email" value="{{ $phone_number }}" disabled></h3>
                    </div>
                    <div class="email">
                        <h3>パスワード:<input type="password" value="********" disabled></h3>
                    </div>
                </div>
            </div>
            <div class="upperRightMiddleBox">
                <div class="d-flex align-items-center  mb-4">
                    <img src="{{ asset('img/company-setting.svg') }}" alt="Company Setting Icon">
                    <h2 class="m-0 mb-5">会社情報</h2>
                </div>
                <div class="d-flex justify-content-around">
                    <h3>会社名:{{ $company_name }}</h3>
                    <h3>役職:{!! $position_name !!}</h3>
                    <h3>部署:{!! $department_name !!}</h3>
                    <h3>36協定:{!! $agreement36 !!}</h3>
                    <h3>変形時間労働制:</h3>
                </div>
            </div>
            <div class="upperRightBottomBox">
                <div class="d-flex align-items-center mb-4">
                    <img src="{{ asset('img/task-setting.svg') }}" alt="Task Result Icon">
                    <h2 class="m-0">過去のタスク履歴</h2>
                </div>
                <div class="d-flex justify-content-around">
                    <h3>割り当て数:</h3>
                    <h3>期限内達成数:</h3>
                    <h3>期限後達成数:</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="lowerBox d-flex">
        <div class="law">
            <h2 class="text-center mb-5">契約情報</h2>
            <form action="{{ route('profile.store') }}" method="POST">
                @csrf
                <div class="agreement36 mb-5 mx-auto">
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
                <div class="variableWorkingHoursSystem mb-5 mx-auto">
                    <label for="variableWorkingHoursSystem">{{ __('変形時間労働制') }}</label>
                    <select class="form-select" aria-label="Variable Working Hours System" name="variableWorkingHoursSystem">
                        <option selected value="unset">未選択</option>
                        <option value="agreed">有り</option>
                        <option value="declined">無し</option>
                    </select>
                </div>
                <div class="saveButton text-center">
                    <button type="submit">
                        {{ __('保存') }}
                    </button>
                </div>
            </form>
        </div>
        @can('boss')
        <div class="company">
            <div class="title">
                <h2 class="text-center mb-5">会社情報</h2>
            </div>
            <form action="{{ route('profile.store2') }}" method="POST">
                @csrf
                <div class="companyName col-md-6 mb-5 mx-auto">
                    <label for="companyName">{{ __('会社名') }}</label>
                    <input id="companyName" type="text" name="companyName" value="{{ old('companyName') }}" required autocomplete="companyName">
                </div>
                <div class="companyPostCode col-md-6 mb-5 mx-auto">
                    <label for="companyPostCode">{{ __('会社の郵便番号') }}</label>
                    <input id="companyPostCode" type="text" name="companyPostCode" value="{{ old('companyPostCode') }}"  required autocomplete="companyPostCode" minlength=7 maxlength=7>
                </div>
                <div class="companyAddress col-md-6 mb-5 mx-auto">
                    <label for="companyAddress">{{ __('会社の住所') }}</label>
                    <input id="companyAddress" type="text" name="companyAddress" value="{{ old('companyAddress') }}"  required autocomplete="companyAddress">
                </div>
                <div class="saveButton text-center">
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