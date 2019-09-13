<?php
require APPPATH . 'libraries/REST_Controller.php';

class Api extends REST_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->helper('common');
        $this->load->library('form_validation');
        $this->load->model('rewards_model');
        $this->load->model('users_model');
        $this->load->model('userrewards_model');
    }

    public function daily_rewards_get($date=null) {
        try {
            $rewards = $this->rewards_model->get_daily_rewards($date);
            return $this->response(['message' => $rewards]);
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
            return $this->response(['message' => $message], self::HTTP_BAD_REQUEST);
        }
    }

    public function daily_rewards_post() {
        try {
            $validationError = [];
            if (!$this->post('date'))
                array_push($validationError, 'date is required');
            else
            if (!helper_check_date_format($this->post('date')))
                array_push($validationError, 'incorrect date format');

            if (!$this->post('amount'))
                array_push($validationError, 'amount is required');

            if (sizeof($validationError) > 0) {
                throw new \Exception(implode(', ', $validationError));
            }

            $data = [
                'reward_date'   => $this->post('date'),
                'reward_amount' => $this->post('amount')
            ];

            $status = $this->rewards_model->insert_daily_rewards($data);
            if (is_string($status))
                throw new \Exception($status);

            return $this->response(['message' => 'Daily reward successfully posted.']);
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
            return $this->response(['message' => $message], self::HTTP_BAD_REQUEST);
        }
    }

    public function daily_rewards_put() {
        try {
            $validationError = [];
            if (!$this->put('date'))
                array_push($validationError, 'date is required');
            else
            if (!helper_check_date_format($this->put('date')))
                array_push($validationError, 'incorrect date format');

            if (!$this->put('amount'))
                array_push($validationError, 'amount is required');
            else
            if (!is_numeric($this->put('amount')))
                array_push($validationError, 'amount must be numeric');

            if (sizeof($validationError) > 0) {
                throw new \Exception(implode(', ', $validationError));
            }

            $data = [
                'reward_date'   => $this->put('date'),
                'reward_amount' => $this->put('amount')
            ];

            $status = $this->rewards_model->update_daily_rewards($data);
            if (is_string($status))
                throw new \Exception($status);

            return $this->response(['message' => 'Daily reward successfully updated.']);
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
            return $this->response(['message' => $message], self::HTTP_BAD_REQUEST);
        }
    }

    public function daily_rewards_delete() {
        try {
            $validationError = [];
            if (!$this->delete('date'))
                array_push($validationError, 'date is required');

            if (sizeof($validationError) > 0) {
                throw new \Exception(implode(', ', $validationError));
            }

            $data = [
                'reward_date' => $this->delete('date')
            ];

            $status = $this->rewards_model->delete_daily_rewards($data);
            if (is_string($status))
                throw new \Exception($status);

            return $this->response(['message' => 'Daily Reward successfully deleted.']);
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
            return $this->response(['message' => $message], self::HTTP_BAD_REQUEST);
        }
    }

    public function users_get($username=null) {
        try {
            $users = $this->users_model->get_users($username);
            return $this->response(['message' => $users]);
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
            return $this->response(['message' => $message], self::HTTP_BAD_REQUEST);
        }
    }

    public function users_post() {
        try {
            $validationError = [];
            if (!$this->post('username'))
                array_push($validationError, 'username is required');
            if (!$this->post('fullname'))
                array_push($validationError, 'fullname is required');

            if (sizeof($validationError) > 0) {
                throw new \Exception(implode(', ', $validationError));
            }

            $data = [
                'username' => $this->post('username'),
                'fullname' => $this->post('fullname')
            ];

            $status = $this->users_model->insert_user($data);
            if (is_string($status))
                throw new \Exception($status);

            return $this->response(['message' => 'User successfully posted.']);
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
            return $this->response(['message' => $message], self::HTTP_BAD_REQUEST);
        }
    }

    public function users_put() {
        try {
            $validationError = [];
            if (!$this->put('username'))
                array_push($validationError, 'username is required');
            if (!$this->put('fullname'))
                array_push($validationError, 'fullname is required');

            if (sizeof($validationError) > 0) {
                throw new \Exception(implode(', ', $validationError));
            }

            $data = [
                'username' => $this->put('username'),
                'fullname' => $this->put('fullname')
            ];

            $status = $this->users_model->update_user($data);
            if (is_string($status))
                throw new \Exception($status);

            return $this->response(['message' => 'User successfully updated.']);
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
            return $this->response(['message' => $message], self::HTTP_BAD_REQUEST);
        }
    }

    public function users_delete() {
        try {
            $validationError = [];
            if (!$this->delete('username'))
                array_push($validationError, 'username is required');

            if (sizeof($validationError) > 0) {
                throw new \Exception(implode(', ', $validationError));
            }

            $data = [
                'username' => $this->delete('username')
            ];

            $status = $this->users_model->delete_user($data);
            if (is_string($status))
                throw new \Exception($status);

            return $this->response(['message' => 'User successfully deleted.']);
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
            return $this->response(['message' => $message], self::HTTP_BAD_REQUEST);
        }
    }

    public function user_rewards_get() {
        try {
            $rewards = $this->userrewards_model->get_user_rewards();
            return $this->response(['message' => $rewards]);
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
            return $this->response(['message' => $message], self::HTTP_BAD_REQUEST);
        }
    }

    public function user_rewards_post() {
        try {
            $validationError = [];
            if (!$this->post('username'))
                array_push($validationError, 'username is required');
            if (!$this->post('date'))
                array_push($validationError, 'date is required');
            else
            if (!helper_check_date_format($this->post('date')))
                array_push($validationError, 'incorrect date format');

            if (sizeof($validationError) > 0) {
                throw new \Exception(implode(', ', $validationError));
            }

            $data = [
                'username'    => $this->post('username'),
                'reward_date' => $this->post('date')
            ];

            $status = $this->userrewards_model->insert_user_rewards($data);
            if (is_string($status))
                throw new \Exception($status);

            return $this->response(['message' => 'User reward successfully posted.']);
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
            return $this->response(['message' => $message], self::HTTP_BAD_REQUEST);
        }
    }

    public function user_rewards_delete() {
        try {
            $validationError = [];
            if (!$this->delete('date'))
                array_push($validationError, 'date is required');
            if (!$this->delete('username'))
                array_push($validationError, 'username is required');

            if (sizeof($validationError) > 0) {
                throw new \Exception(implode(', ', $validationError));
            }

            $data = [
                'username'    => $this->delete('username'),
                'reward_date' => $this->delete('date')
            ];

            $status = $this->userrewards_model->delete_user_rewards($data);
            if (is_string($status))
                throw new \Exception($status);

            return $this->response(['message' => 'User Reward successfully deleted.']);
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
            return $this->response(['message' => $message], self::HTTP_BAD_REQUEST);
        }
    }
}
?>
