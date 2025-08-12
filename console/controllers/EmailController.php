<?php
namespace console\controllers;

use Yii;
use common\models\SalesContact;
use yii\console\Controller;
use yii\helpers\Html;

/**
 * Controller for sending emails to SalesContact emails.
 */
class EmailController extends Controller
{

    /**
     * Sends a test introduction email to a single email address.
     * @param string $email The email address to send the test email to (default: test@example.com)
     */
    public function actionTestEmail($email = 'test@example.com')
    {
        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->stdout("Invalid email address: $email\n");
            return Controller::EXIT_CODE_ERROR;
        }

        try {
            $result = Yii::$app->mailer->compose('@common/mail/introduce-bdsdaily', [
                'name' => 'Test User',
                'email' => $email,
            ])
                ->setFrom(['no-reply@bdsdaily.com' => 'BDSDaily'])
                ->setTo($email)
                ->setSubject('Giới thiệu BDSdaily - Nền tảng Bất động sản Dành cho Sales')
                ->send();

            if ($result) {
                $this->stdout("Test email sent successfully to $email\n");
                $this->stdout("Check MailHog at http://localhost:8025 to view the email.\n");
            } else {
                $this->stdout("Failed to send test email to $email\n");
            }
        } catch (\Exception $e) {
            $this->stdout("Error sending test email to $email: {$e->getMessage()}\n");
            return Controller::EXIT_CODE_ERROR;
        }

        return Controller::EXIT_CODE_NORMAL;
    }

    /**
     * Sends promotional email to all SalesContact emails.
     */
    public function actionSendProjectEmail()
    {
        $project = [
            'name' => 'Vinhomes Grand Park',
            'location' => 'Quận 9, TP.HCM',
            'type' => 'Căn hộ cao cấp, shophouse',
            'price' => '2.5 tỷ VND',
            'highlights' => 'Tiện ích hiện đại, vị trí gần trung tâm, tiềm năng tăng giá cao',
            'url' => 'https://bdsdaily.com/projects/vinhomes-grand-park',
        ];


        $contacts = SalesContact::find()->all();
        $total = count($contacts);
        $sent = 0;
        $failed = 0;

        foreach ($contacts as $index => $contact) {
            if (empty($contact->email) || !filter_var($contact->email, FILTER_VALIDATE_EMAIL)) {
                $this->stdout("Skipping invalid email for contact ID {$contact->id}\n");
                $failed++;
                continue;
            }

            try {
                $result = Yii::$app->mailer->compose('@common/mail/project-promotion', [
                    'name' => $contact->name,
                    'email' => $contact->email,
                    'project' => $project,
                ])
                    ->setFrom(['no-reply@bdsdaily.com' => 'BDSdaily'])
                    ->setTo($contact->email)
                    ->setSubject('Khám phá Dự án Bất động sản Mới với BDSdaily!')
                    ->send();

                if ($result) {
                    $this->stdout("Email sent to {$contact->email} (Contact ID: {$contact->id})\n");
                    $sent++;
                } else {
                    $this->stdout("Failed to send email to {$contact->email} (Contact ID: {$contact->id})\n");
                    $failed++;
                }
            } catch (\Exception $e) {
                $this->stdout("Error sending email to {$contact->email}: {$e->getMessage()}\n");
                $failed++;
            }

            usleep(500000);

            if (($index + 1) % 10 == 0) {
                $this->stdout("Processed " . ($index + 1) . "/$total contacts\n");
            }
        }

        $this->stdout("Email sending completed. Sent: $sent, Failed: $failed, Total: $total\n");
    }
}
