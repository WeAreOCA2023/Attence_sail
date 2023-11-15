<?php

namespace App\Constants;

class AgreementConstants
{
    /**
    * 36協定も変形時間労働制も合意していない、法定労働時間(労働基準法第32条)
    */
    // 1日の上限は40時間
    const DEFAULT_DAILY_LIMIT = 8;

    // 1週間の上限は40時間
    const DEFAULT_WEEKLY_LIMIT = 40;


    /**
    * 36協定を締結している場合
    */
    // 月の時間外労働の合計上限時間
    const MONTHLY_OVERTIME_LIMIT = 45;

    // 年の時間外労働の合計上限時間
    const YEARLY_OVERTIME_LIMIT = 360;


    /**
    * 特別条項付き36協定を締結している場合
    */
    // 年の時間外労働の合計上限時間
    const SPECIAL_YEARLY_OVERTIME_LIMIT = 720;
    
    // 「時間外労働+休日労働」の合計が1ヵ月100時間未満
    const SPECIAL_MONTHLY_TOTAL_LIMIT = 100;

    // 時間外労働が月45時間を超えられる上限回数
    const OVERTIME_EXCEEDANCE_LIMIT = 6;

    // 「時間外労働+休日労働」の合計が「2ヵ月」「3ヵ月」「4ヵ月」「5ヵ月」「6ヵ月」のどこの平均をとってもすべて1ヵ月当たり80時間以内
    const AVERAGE_TOTAL_LIMIT = 80;


    /**
    * 1週間単位の変形時間労働制を締結している場合
    */
    // 1日の労働時間の上限
    const WEEKLY_VARIABLE_DAILY_LIMIT = 10;

    // 1週間の労働時間の上限
    const WEEKLY_VARIABLE_WEEKLY_LIMIT = 40;


    /**
    * 1カ月単位の変形時間労働制を締結している場合
    */
    // 1週間の平均労働時間の上限
    const MONTHLY_VARIABLE_WEEKLY_AVERAGE_LIMIT = 40;


    /**
    * 1年単位の変形時間労働制を締結している場合
    */  
    // 1日の労働時間の上限
    const YEALY_VARIABLE_DAILY_LIMIT = 10;

    // 1週間の労働時間の上限
    const YEALY_VARIABLE_WEEKLY_LIMIT = 52;


    /**
    * 休憩時間に関して
    */
    // 労働時間が6時間以内の場合、最低休憩時間は0分
    const BREAK_TIME_LESS_6HOURS = 0;

    // 労働時間が6時間を超え8時間以内の場合、最低休憩時間は45分(0.75時間)
    const BREAK_TIME_LESS_8HOURS = 45;

    // 労働時間が8時間を超える場合、最低休憩時間は1時間(1.0時間)
    const BREAK_TIME_OVER_8HOURS = 60;
}