const express = require('express');
const router = express.Router();
const animalController = require('../controllers/animalController');

router.get('/listAll', animalController.listAnimals);
router.post('/selectedPet', animalController.getUserSelectedAnimal);

module.exports = router;