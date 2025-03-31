const mysql = require('mysql2/promise');
const dotenv = require('dotenv');

dotenv.config();

const pool = mysql.createPool({
  host: 'localhost',
  user: 'root',
  password: 'V1n1c1us',
  database: 'high_five_hackathon',
  multipleStatements: true,
});

module.exports = pool;
