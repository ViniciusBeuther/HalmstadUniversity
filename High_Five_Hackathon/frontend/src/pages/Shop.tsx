import { useEffect, useState } from 'react';
import Header from '../components/Layout/Header';
import catIcon from '../assets/shopIcons/cat-svgrepo-com.svg';
import duckIcon from '../assets/shopIcons/duck-svgrepo-com.svg';
import lhamaIcon from '../assets/shopIcons/llama-svgrepo-com.svg';
import rabbitIcon from '../assets/shopIcons/rabbit-svgrepo-com.svg';
import rayIcon from '../assets/shopIcons/ray-svgrepo-com.svg';
import dogIcon from '../assets/shopIcons/siberian-husky-svgrepo-com.svg';
import squirrelIcon from '../assets/shopIcons/squirrel-svgrepo-com.svg';
import tigerIcon from '../assets/shopIcons/tiger-svgrepo-com.svg';
import turtleIcon from '../assets/shopIcons/turtle-svgrepo-com.svg';
import { Card, CardContent, CardDescription, CardFooter } from '../components/ui/card';
import { Check, CircleDollarSign } from 'lucide-react';
import { Button } from '../components/ui/button';


interface AnimalInterface{
  animal_id: number,
  animal_name: string,
  animal_price: number
};

const Shop:React.FC = () => {
  const [animals, setAnimals] = useState<AnimalInterface[]>();

  const selectAnimalIcon = ( animal_name:string ) => {
    switch(animal_name){
      case "Dog":
        return dogIcon;
      case "Cat":
        return catIcon;
      case "Duck":
        return duckIcon;
      case "Llama":
        return lhamaIcon;
      case "Bunny":
        return rabbitIcon;
      case "Stingray":
        return rayIcon;
      case "Squirrel":
        return squirrelIcon;
      case "Turtle":
        return turtleIcon;
      case "Tiger":
        return tigerIcon;
    }
  };

  const fetchAnimals = async () => {
    console.log('starting fetching')
    const response = await fetch('http://localhost:3001/animals/listAll', {
      method: 'GET'
    });
    
    const data: AnimalInterface[] = await response.json();
    setAnimals(data);
  };

  // fetch animals from server
  useEffect(() => {
    fetchAnimals();
  }, []);

  return (  
    <main className='h-[100vh] overflow-y-hidden'>
      <Header />
      <article className='bg-violet-100 h-[100%] py-5'>
        <div className='flex flex-wrap gap-5 items-start justify-center'>
          { animals != null ? (
            animals.map((animal) => (
              <Card 
                key={animal.animal_id}
                className='px-4 shadow-lg'
              >
                <CardContent>
                  <img src={selectAnimalIcon(animal.animal_name)} alt={animal.animal_name} className='w-32 h-32' />
                </CardContent>
                <CardDescription>
                <h2
                  className='text-center text-black text-bold'
                >{animal.animal_name}</h2>
                <section className='mt-5 flex items-center justify-end'>

                  { animal.animal_name != 'Dog' && animal.animal_name != 'Llama' ? (
                <button
                  className="flex items-center gap-2 text-black bg-white border-2 border-violet-300 hover:bg-violet-300 hover:cursor-pointer text-xl px-2 py-1 rounded-md"
                >
                      <CircleDollarSign className="w-7 h-7 text-yellow-500" />
                      {animal.animal_price}
                </button>
                  ) : (
                    <span className='flex items-center gap-1 justify-center mb-1 bg-green-200 px-2 py-1 rounded-md'>
                      <Check className="w-5 h-5 text-green-500" />
                      <p className='text-lg text-green-500 h-[100%] m-0'>Bought</p>
                    </span>
                  ) }
                </section>
                </CardDescription>
              </Card>
            ))
          ) : <p>Loading...</p> }
        </div>
      </article>
    </main>
  )
}

export default Shop;