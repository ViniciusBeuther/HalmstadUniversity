const pool = require('../config/database');

exports.login = async (req, res) => {
  try{
    console.log("got the HTPP Request");
    const { username, password } = req.body;
    if (!username || !password) {
      return res.status(400).send('Username and password are required.');
    }
    
    // Query in database
    const [users] = await pool.query('SELECT * FROM user WHERE username = ? AND password = ?', [username, password]);
    console.log(users)
  
    // Check if the user exists
    if (users.length === 0) {
      return res.status(404).send('Wrong credentials!');
    } 
  
    return res.status(200).send({message: 'Login successfully!', data: [users[0]]});
  } catch(error){
    console.log(error)
  }
}