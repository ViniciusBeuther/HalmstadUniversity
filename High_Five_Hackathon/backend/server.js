const express = require('express');
const app = express();
const cors = require('cors');
const loginRoute = require('./routes/LogInRoutes');
const animalRoute = require('./routes/animalRoutes');

app.use(express.json());
app.use(cors({ origin: 'http://localhost:5174' }));


app.use('/auth', loginRoute);
app.use('/animals', animalRoute);

app.listen(3001, () => {
  console.log('Server is running on http://localhost:3001');
});
