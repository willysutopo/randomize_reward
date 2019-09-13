<?php
class Userrewards_model extends CI_Model {
    private $userRewardTable;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('common');
        $this->userRewardTable = 'user_rewards';
    }

    public function get_user_rewards()
    {
        $sql = "SELECT r.username, u.fullname, r.reward_date, r.min_amount, 
            r.max_amount, r.reward_amount, r.actual_amount, r.created_at, 
            d.reward_amount as daily_reward
            FROM {$this->userRewardTable} AS r
            INNER JOIN users AS u ON u.username = r.username
            INNER JOIN daily_reward AS d on d.reward_date = r.reward_date
            ORDER BY r.reward_date, r.id";
        $query = $this->db->query($sql);

        $rewards = array();
        $i = 0;

        if ($query->num_rows() > 0) {
            $prevRewardDate = '';
            foreach ($query->result() as $row) {
                if ($prevRewardDate != $row->reward_date)
                    $balance = $row->daily_reward;
                $rewards[$i]['reward_date'] = $row->reward_date;
                $rewards[$i]['username'] = $row->username;
                $rewards[$i]['fullname'] = $row->fullname;
                $rewards[$i]['min_amount'] = floatval($row->min_amount);
                $rewards[$i]['max_amount'] = floatval($row->max_amount);
                $rewards[$i]['reward_amount'] = floatval($row->reward_amount);
                $rewards[$i]['actual_amount'] = floatval($row->actual_amount);
                $rewards[$i]['daily_reward'] = floatval($row->daily_reward);
                $rewards[$i]['created_at'] = $row->created_at;
                $prevRewardDate = $row->reward_date;
                $balance = $balance - $row->actual_amount;
                $rewards[$i]['balance'] = floatval($balance);
                $i++;
            }
        }

        return $rewards;
    }

    public function get_total_rewards_by_date($date)
    {
        $sql = "SELECT SUM(actual_amount) as total_reward
            FROM {$this->userRewardTable}
            WHERE reward_date = '$date'";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                return $row->total_reward;
            }
        }

        return 0;
    }

    public function insert_user_rewards($data)
    {
        try {
            $query = $this->db->get_where($this->userRewardTable,
                array(
                    'reward_date' => $data['reward_date'],
                    'username' => $data['username']
                ));
            if ($query->num_rows() > 0) {
                return 'This user has been rewarded on selected date. Please choose another date.';
            }

            $this->load->model('rewards_model');

            $multiplier = 1000;
            $rewards = helper_get_rewards(10, 100, $multiplier);
            $data['min_amount'] = $rewards['min'];
            $data['max_amount'] = $rewards['max'];

            $dailyReward = $this->rewards_model->get_daily_reward_by_date($data['reward_date']);
            $totalCollectedReward = $this->get_total_rewards_by_date($data['reward_date']);

            $remainingReward = $dailyReward - $totalCollectedReward;
            $data['reward_amount'] = $rewards['reward'];
            $data['actual_amount'] = (($rewards['reward'] > $remainingReward) ? $remainingReward : $rewards['reward']);
            $this->db->insert($this->userRewardTable, $data);
            return true;
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
            return $message;
        }
    }

    public function delete_user_rewards($data)
    {
        try {
            $query = $this->db->get_where($this->userRewardTable, 
                array(
                    'username'    => $data['username'],
                    'reward_date' => $data['reward_date']
                ));
            if ($query->num_rows() == 0) {
                return 'There is no user reward you want to delete';
            }
            $this->db->delete($this->userRewardTable, 
                array(
                    'username'    => $data['username'],
                    'reward_date' => $data['reward_date']
                ));
            return true;
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
            return $message;
        }
    }
}