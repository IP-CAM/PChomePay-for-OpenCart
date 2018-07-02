<?php
/**
 * Created by PhpStorm.
 * User: Jerry
 * Date: 2018/1/11
 * Time: 下午1:58
 */

class pchomepayOrderStatusEnum
{
    /**  order status
     *       1        Pending       訂單剛剛創建,等待處理.
     *       2        Processing    當客戶付款完成,訂單狀態即為處理中.
     *       3        Shipped       當訂單已發出,訂單狀態請設為Shipped.
     *       5        Complete      客戶已確認收貨,訂單狀態請設為Complete.
     *       7        Cancelled     出於某些原因,訂單取消.請將訂單狀態設為Cancelled.
     *      10        Failed        訂單失敗
     *      11        Refunded      如客戶退貨或退款.訂單狀態請設為Refunded.
     *      14        Expired       訂單逾期
     */
    const PENDING = 1;
    const PROCESSING = 2;
    const SHIPPED = 3;
    const COMPLETE = 5;
    const CANCELLED = 7;
    const FAILED = 10;
    const REFUNDED = 11;
    const EXPIRED = 14;


    /** 訂單過期 */
    const ORDER_EXPIRED = "FE";

    /** 餘額不足 */
    const BALANCE_NOT_ENOUGH = "FB";

    /** ATM 虛擬帳號失效 */
    const ATM_EXPIRED = "FX";

    /** 連線失敗 */
    const GATEWAY_TIMEOUT = "FT";

    /** 支付連授權失敗 */
    const PP_FILTER_FAILED = "FF";

    /** 信用卡授權失敗 */
    const AUDIT_FAILED = "FA";

    /** 審單失敗 */
    const PP_AUDIT_FAILED = "FP";

    /** 廠商審單不過單 */
    const CUSTOMER_AUDIT_FAILED = "FC";

    /** eACH 超過限額 */
    const EACH_LIMIT_FAILED = "FEL";

    /** eACH 超過交易次數 */
    const EACH_PAYMENT_COUNT_FAILED = "FEC";

    /** eACH 帳戶存款不足 */
    const EACH_BALANCE_NOT_ENOUGH = "FEB";

    /** eACH 帳戶異常 */
    const EACH_ACCOUNT_FAILED = "FEA";

    /** eACH 接收單位業務停止或關閉 */
    const EACH_SERVICE_CLOSE = "FES";

    /** eACH 交易發生逾時 */
    const EACH_TIMEOUT_FAILED = "FET";

    /** ATM 待繳款 */
    const ORDER_ATM_PAYING = "WP";

    /** 尚未選擇銀行 */
    const ORDER_WAIT_SELECT_BANK = "WB";

//    /** 訂單審單中 */
//    const ORDER_PENDING = "WA";

    /** 訂單審單中 */
    const ORDER_PENDING_PCHOMEPAY = "WAP";

    /** 訂單審單中 */
    const ORDER_PENDING_CLIENT = "WAC";

    /** 銀行支付 等待OTP驗證 */
    const EACH_ORDER_OTP_WAIT = "WO";

    public static function getErrMsg($code)
    {
        $msg = [
            static::ORDER_EXPIRED => '訂單過期',
            static::BALANCE_NOT_ENOUGH => '餘額不足',
            static::ATM_EXPIRED => 'ATM 虛擬帳號失效',
            static::GATEWAY_TIMEOUT => '連線失敗',
            static::PP_FILTER_FAILED => '支付連授權失敗',
            static::AUDIT_FAILED => '信用卡授權失敗',
            static::PP_AUDIT_FAILED => '審單失敗',
            static::CUSTOMER_AUDIT_FAILED => '廠商審單不過單',
            static::EACH_LIMIT_FAILED => 'eACH 超過限額',
            static::EACH_PAYMENT_COUNT_FAILED => 'eACH 超過交易次數',
            static::EACH_BALANCE_NOT_ENOUGH => 'eACH 帳戶存款不足',
            static::EACH_ACCOUNT_FAILED => 'eACH 帳戶異常',
            static::EACH_SERVICE_CLOSE => 'eACH 接收單位業務停止或關閉',
            static::EACH_TIMEOUT_FAILED => 'eACH 交易發生逾時',
            static::ORDER_ATM_PAYING => 'ATM 待繳款',
            static::ORDER_WAIT_SELECT_BANK => '尚未選擇銀行',
            static::ORDER_PENDING => '訂單審單中',
            static::EACH_ORDER_OTP_WAIT => '銀行支付 等待OTP驗證',
        ];

        return $msg[$code];
    }
}