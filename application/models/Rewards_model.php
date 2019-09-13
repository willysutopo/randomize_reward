<?php
class Rewards_model extends CI_Model {
    private $dailyRewardTable;

    public function __construct()
    {
        parent::__construct();
        $this->dailyRewardTable = 'daily_reward';
    }

    public function get_daily_rewards($date)
    {
        $conditions = (!is_null($date) ? "WHERE reward_date='$date'" : "");
        $sql = "SELECT * FROM {$this->dailyRewardTable} $conditions ORDER BY reward_date";
        $query = $this->db->query($sql);

        $rewards = array();
        $i = 0;

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $rewards[$i]['id'] = intval($row->id);
                $rewards[$i]['reward_date'] = $row->reward_date;
                $rewards[$i]['reward_amount'] = floatval($row->reward_amount);
                $i++;
            }
        }

        return $rewards;
    }

    public function get_daily_reward_by_date($date)
    {
        $sql = "SELECT reward_amount FROM {$this->dailyRewardTable}
            WHERE reward_date = '$date'";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                return $row->reward_amount;
            }
        }

        return 0;
    }

    public function insert_daily_rewards($data)
    {
        try {
            $query = $this->db->get_where($this->dailyRewardTable, 
                array('reward_date' => $data['reward_date']));
            if ($query->num_rows() > 0) {
                return 'The date you selected has a reward already. Please choose another date';
            }
            $this->db->insert($this->dailyRewardTable, $data);
            return true;
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
            return $message;
        }
    }

    public function update_daily_rewards($data)
    {
        try {
            $query = $this->db->get_where($this->dailyRewardTable, 
                array('reward_date' => $data['reward_date']));
            if ($query->num_rows() == 0) {
                return 'There is no date you want to update.';
            }
            $this->reward_amount = $data['reward_amount'];
            $this->db->update($this->dailyRewardTable, $this, 
                array('reward_date' => $data['reward_date']));
            return true;
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
            return $message;
        }
    }

    public function delete_daily_rewards($data)
    {
        try {
            $query = $this->db->get_where($this->dailyRewardTable, 
                array('reward_date' => $data['reward_date']));
            if ($query->num_rows() == 0) {
                return 'There is no date you want to delete';
            }
            $this->db->delete($this->dailyRewardTable, 
                array('reward_date' => $data['reward_date']));
            return true;
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
            return $message;
        }
    }
}