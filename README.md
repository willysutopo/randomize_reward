# Randomize Reward API Exercise

This simple exercise was built using CodeIgniter 3.1. These projects consist of API to create users, daily rewards and user rewards.  Go to project root, then run Dockerfile and run Mysql to load initial db :
```sh
$ mysql -u root -p < initial.sql
```

To run unit test, go to project root, then run :
```sh
$ cd application/tests
$ ../../vendor/bin/phpunit
```

# API Collections
### Users
  - GET: {url}/api/users
  - GET: {url}/api/users/{username}
  - POST: {url}/api/users where Request body : {"username":"test", "fullname": "Test"}
  - PUT: {url}/api/users where Request body : {"username":"test", "fullname": "Changed"}
  - DELETE: {url}/api/users where Request body : {"username":"test"}

### Daily Rewards
  - GET: {url}/api/daily_rewards
  - GET: {url}/api/daily_rewards/{date}
  - POST: {url}/api/daily_rewards where Request body : {"date":"2019-09-14", "amount": 200000}
  - PUT: {url}/api/daily_rewards where Request body : {"date":"2019-09-14", "amount": 250000}
  - DELETE: {url}/api/daily_rewards where Request body : {"date":"2019-09-14"}

### User Rewards
  - GET: {url}/api/user_rewards
  - POST: {url}/api/user_rewards where Request body : {"date":"2019-09-14", "fullname": "testing"}
  - DELETE: {url}/api/user_rewards where Request body : {"date":"2019-09-14", "fullname": "testing"}
