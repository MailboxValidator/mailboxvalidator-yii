<?php
namespace MailboxValidator;


use Yii;
use yii\validators\Validator;
use MailboxValidator\EmailValidation;

class MailboxValidator extends Validator{
	
	protected $mbv;
	public  $option;
	public $api_key;
	

	public function validateAttribute($model, $attribute){
		Yii::debug('Mailboxvalidator plugin Initialized.');
		if (strpos($this->option, ',') == false) {
			if ($this->option == 'disposable') {
				if ($this->validateDisposable($model->$attribute, $this->api_key) == false) {
					$this->addError($model, $attribute, 'Disposable email found.');
					return false;
				} else {
					return true;
				}
			} elseif ($this->option == 'free') {
				if ($this->validateFree($model->$attribute) == false) {
					$this->addError($model, $attribute, 'Free email found.');
					return false;
				} else {
					return true;
				}
			}
		} else {
			$options = explode(',', $this->option);
			foreach ($options as $option_key => $option_value) {
				if ($option_value == 'disposable') {
					if ($this->validateDisposable($model->$attribute) == false) {
						$this->addError($model, $attribute, 'Disposable email found.');
						return false;
					} else {
						return true;
					}
				} elseif ($option_value == 'free') {
					if ($this->validateFree($model->$attribute) == false) {
						$this->addError($model, $attribute, 'Free email found.');
						return false;
					} else {
						return true;
					}
				}
			}
		}
	}
	public function validateDisposable($email,$key = '') {
		if ($key != '') {
			$this->mbv = new EmailValidation($key);
		} else {
			$this->mbv = new EmailValidation(Yii::$app->params['mbvAPIKey']);
		}
		$result = $this->mbv->isDisposableEmail($email);
		if ($result != false && $result->error_code == '') {
			if ($result->is_disposable == 'True') {
				file_put_contents( '../mbv_log.log', date('d M, Y h:i:s A') . PHP_EOL, FILE_APPEND);
				file_put_contents( '../mbv_log.log', json_encode($result) . PHP_EOL, FILE_APPEND);
				return false;
			} else {
				file_put_contents( '../mbv_log.log', date('d M, Y h:i:s A') . PHP_EOL, FILE_APPEND);
				file_put_contents( '../mbv_log.log', json_encode($result) . PHP_EOL, FILE_APPEND);
				return true;
			}
		} else {
			Yii::error('MBV API Error: ' . $result->error_code .'-' . $result->error_message);
			file_put_contents('../mbv_error_log.log', date('d M, Y h:i:s A') . PHP_EOL, FILE_APPEND);
			file_put_contents('../mbv_error_log.log', 'MBV API Error: ' . $result->error_code .'-' . $result->error_message . PHP_EOL, FILE_APPEND);
			return false;
		}
	}
	public function validateFree($email,$key = '') {
		if ($key != '') {
			$this->mbv = new EmailValidation($key);
		} else {
			$this->mbv = new EmailValidation(Yii::$app->params['mbvAPIKey']);
		}
		$result = $this->mbv->isFreeEmail($email);
		if ($result != false && $result->error_code == '') {
			if ($result->is_free == 'True') {
				file_put_contents( '../mbv_log.log', date('d M, Y h:i:s A') . PHP_EOL, FILE_APPEND);
				file_put_contents( '../mbv_log.log', json_encode($result) . PHP_EOL, FILE_APPEND);
				return false;
			} else {
				file_put_contents( '../mbv_log.log', date('d M, Y h:i:s A') . PHP_EOL, FILE_APPEND);
				file_put_contents( '../mbv_log.log', json_encode($result) . PHP_EOL, FILE_APPEND);
				return true;
			}
		} else {
			Yii::error('MBV API Error: ' . $result->error_code .'-' . $result->error_message);
			file_put_contents('../mbv_error_log.log', date('d M, Y h:i:s A') . PHP_EOL, FILE_APPEND);
			file_put_contents('../mbv_error_log.log', 'MBV API Error: ' . $result->error_code .'-' . $result->error_message . PHP_EOL, FILE_APPEND);
			return false;
		}
	}
}
?>
