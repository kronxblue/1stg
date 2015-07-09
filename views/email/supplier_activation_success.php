<html>
    <body style="padding: 0px; margin: 0px; font-family: 'Verdana'; color: #666; max-width: 960px;">
        <div style="display: block; height: 15px;"></div>
        <div style="background-color: #444; margin: 0px; padding: 0px;">
            <a href="<?php echo BASE_PATH; ?>" style="color: #ddd; text-decoration: none; border: 0px; display: block; padding: 5px; margin: 10px auto;">
                <img src="<?php echo IMAGES_PATH; ?>1stg-logo.png" title="1 Stop Traffic Generator" style="border: 0px;" />
            </a>
        </div>

        <div style="font-size: 14px; display: block; min-height: 200px; margin: 10px auto 0px; background-color: #fff; padding: 20px;">
            <p><b>Welcome [FULLNAME],</b></p>
            <p>Thank you for joining the <?php echo SITE_TITLE; ?>. You've taken the first step towards world domination! New features roll out daily.</p>
            <p>Below you will find all your account information, please keep it in a safe place:</p>
            <br/>
            <hr style="border: 1px dashed #ccc;"/>
            <br/>

            <p>
                <b>Your agent's login area:</b>
                <br/>
                <?php echo BASE_PATH . 'login'; ?>
            </p>
            <p>
                <b>Your agent ID:</b> [AGENT_ID]
                <br/>
                <b>Account type:</b> [ACC_TYPE] - RM[ACC_PRICE]
                <br/>
                <br/>
                <b>Your username:</b> [USERNAME]
                <br/>
                <b>Your password:</b> [TMP_PASSWORD]
                <br/>
                <br/>
                <b>Refer by:</b>
                <br/>
                [SPONSOR_FULLNAME]
                <br/>
                [SPONSOR_EMAIL]
                <br/>
                [SPONSOR_MOBILE]
            </p>

            <br/>
            <hr style="border: 1px dashed #ccc;"/>
            <br/>

            <p>
                Payment can be made via Cash, Bank Transfer, or Cheque to :

            </p>
            <p>
                <b>Bank :</b> CIMB Bank Berhad
                <br/>
                <b>Account Name :</b> [COMPANY_NAME]
                <br/>
                <b>Account No. :</b> 8007274723
            </p>

            <br/>
            <hr style="border: 1px dashed #ccc;"/>
            <br/>
            <p>
                By signing up <?php echo SITE_TITLE; ?>, you are now one step closer to becoming the next successful entrepreneur. Before that, you will need to setup your account at What You Want portal.
            </p>
            <p>
                After your first login, you will be asked for the following:
            </p>
            <ul>
                <li>Change your account password.</li>
                <li>Your full personal details.</li>
                <li>Your beneficiary's personal details.</li>
                <li>Your bank account.</li>
                <li>Your beneficiary's bank account.</li>
                <li>Payment verification.</li>
            </ul>
            <p>
                Should you still require further information or assistance, kindly feel free to contact our support team at <?php echo SUPPORT_EMAIL; ?> or alternatively you can contact our member who referred you to <?php echo SITE_TITLE; ?>.
            </p>
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
