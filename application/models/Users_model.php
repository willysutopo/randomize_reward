<?php
class Users_model extends CI_Model {
    private $userTable;

    public function __construct()
    {
        parent::__construct();
        $this->userTable = 'users';
    }

    public function get_users($username)
    {
        $conditions = (!is_null($username) ? "WHERE username='$username'" : "");
        $sql = "SELECT * FROM {$this->userTable} $conditions ORDER BY username";
        $query = $this->db->query($sql);

        $users = array();
        $i = 0;

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $users[$i]['id'] = intval($row->id);
                $users[$i]['username'] = $row->username;
                $users[$i]['fullname'] = $row->fullname;
                $users[$i]['created_at'] = $row->created_at;
                $i++;
            }
        }

        return $users;
    }

    public function insert_user($data)
    {
        try {
            $query = $this->db->get_where($this->userTable, 
                array('username' => $data['username']));
            if ($query->num_rows() > 0) {
                return 'Please choose another username. Username already exists';
            }
            $this->db->insert($this->userTable, $data);
            return true;
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
            return $message;
        }
    }

    public function update_user($data)
    {
        try {
            $query = $this->db->get_where($this->userTable, 
                array('username' => $data['username']));
            if ($query->num_rows() == 0) {
                return 'There is no user you want to update.';
            }
            $this->fullname = $data['fullname'];
            $this->db->update($this->userTable, $this, 
                array('username' => $data['username']));
            return true;
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
            return $message;
        }
    }

    public function delete_user($data)
    {
        try {
            $query = $this->db->get_where($this->userTable, 
                array('username' => $data['username']));
            if ($query->num_rows() == 0) {
                return 'There is no username you want to delete';
            }
            $this->db->delete($this->userTable, 
                array('username' => $data['username']));
            return true;
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
            return $message;
        }
    }
}