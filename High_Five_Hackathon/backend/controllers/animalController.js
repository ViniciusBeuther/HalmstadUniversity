const pool = require('../config/database');

exports.listAnimals = async( req, res ) => {
  try{
    const [animals] = await pool.execute(
      `SELECT * FROM Animal;`
    );

    if( animals.length > 0 ){
      return res.status(202).send(animals);
    }
  } catch(error){
    console.log(error);
    return res.status(400).message('API was able to get the animals.');
  }
};

exports.getUserSelectedAnimal = async( req, res ) => {
  try{
    console.log(req.body);
    const { user_id } = req.body;
    const [selected_pet] = await pool.execute(
      `SELECT selected_pet FROM User WHERE user_id = ?`, [user_id] 
    );

    console.log(selected_pet[0]);

    return res.status(200).send(selected_pet[0]);
  } catch(error){
    console.log(`Error getting user selected animal: ${error}`);
    return res.status(500).send({ error: 'Failed to get user selected animal' });
  }
};