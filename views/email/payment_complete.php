<html>
    <body style="padding: 0px; margin: 0px; font-family: 'Verdana'; color: #666; max-width: 960px;">
        <div style="display: block; height: 15px;"></div>
        <div style="background-color: #444; margin: 0px; padding: 0px;">
            <a href="<?php echo BASE_PATH; ?>" style="color: #ddd; text-decoration: none; border: 0px; display: block; padding: 5px; margin: 10px auto;">
                <img src="<?php echo IMAGES_PATH; ?>1stg-logo.png" title="1 Stop Traffic Generator" style="border: 0px;" />
            </a>
        </div>

        <div style="font-size: 14px; display: block; min-height: 200px; margin: 10px auto 0px; background-color: #fff; padding: 20px;">
            <p><b>Thank you [USERNAME],</b></p>
            <p>Your payment has been authorized successfully. Below is the detail of your payment for your reference :</p>
            <br/>
            <hr style="border: 1px dashed #ccc;"/>
            <br/>
            <p>
                <b>Fullname : </b> [FULLNAME]
                <br/>
                <b>Email : </b> [EMAIL]
                <br/>
                <b>Mobile No. : </b> [MOBILE]
                <br/>
                <br/>
                <b>Order No. :</b> [ORDER_NO]
                <br/>
                <b>Amount :</b> [AMOUNT]
                <br/>
                <b>Payment Method :</b> [PAY_METHOD]
                <br/>
                <b>Authorized Date/Time :</b> [AUTH_DATETIME]
                <br/>
                <b>Subject :</b> [PAYMENT_FOR]
            </p>

            <br/>
            <hr style="border: 1px dashed #ccc;"/>
            <br/>

            <p style="color: red; font-size: 12px;">
                <b>Note :</b> Possibility for receiving the duplication of this email notification is possible. You might need to check the Order No. to make sure it only will be charge once.
            </p>
            <br/>
            <br/>
            <p>
                Thanks,
                <br/>
                <?php echo SUPPORT_NAME; ?>
            </p>
        </div>

        <div style="margin: 0px; padding: 20px 0px; text-align: center; font-size: 12px; color: #999;">
            <span style="border: 1px dashed #999; padding: 10px; border-radius: 5px; display: block; margin: 10px auto;">You're receiving this email because you're signed up to 1STG Entrepreneurship Program. You can unsubscribe receiving tips and news update from 1STG by adjusting your notification setting in your 1STG account.</span>
            <span>© Copyright <a href="<?php echo WYW_PATH; ?>" style="color: #999; text-decoration: none;">Whatyouwant.my</a> 2014. All right reserved.</span>
        </div>
        <div style="display: block; height: 15px;"></div>       
    </body>
</html>
