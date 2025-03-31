import { useState, useEffect } from "react";
import { Play, Pause, RotateCcw } from "lucide-react";
import { Button } from "../ui/button";
import { Dialog, DialogContent, DialogHeader, DialogTitle } from "../ui/dialog"; 
import catIcon from '../../assets/shopIcons/cat-svgrepo-com.svg';
import duckIcon from '../../assets/shopIcons/duck-svgrepo-com.svg';
import lhamaIcon from '../../assets/shopIcons/llama-svgrepo-com.svg';
import rabbitIcon from '../../assets/shopIcons/rabbit-svgrepo-com.svg';
import rayIcon from '../../assets/shopIcons/ray-svgrepo-com.svg';
import dogIcon from '../../assets/shopIcons/siberian-husky-svgrepo-com.svg';
import squirrelIcon from '../../assets/shopIcons/squirrel-svgrepo-com.svg';
import tigerIcon from '../../assets/shopIcons/tiger-svgrepo-com.svg';
import turtleIcon from '../../assets/shopIcons/turtle-svgrepo-com.svg';
import mp3Notification from '../../assets/notification/notification.mp3';

interface PomodoroTimerProps {
  selectedAnimal: number;
}

const PomodoroTimer: React.FC<PomodoroTimerProps> = ({ selectedAnimal }) => {
  const WORK_TIME = 25 * 60; // 25 minutes
  const BREAK_TIME = 5 * 60; // 5 minutes
  const [loggedInUserId, setLoggedInUserId] = useState<number>(() => {
    return parseInt(localStorage.getItem("loggedInUserId") || "0");
  });

  const [userSelectedAnimal, setUserSelectedAnimal] = useState<number | null>(null);

  // Fetch selected pet when `loggedInUserId` is set
  useEffect(() => {
    if (loggedInUserId !== 0) {
      fetchSelectedPet();
    }
  }, [loggedInUserId]);

  const fetchSelectedPet = async () => {
    try {
      const response = await fetch("http://localhost:3001/animals/selectedPet", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          user_id: loggedInUserId,
        }),
      });

      if (!response.ok) {
        throw new Error(`Failed to fetch, status: ${response.status}`);
      }

      const data = await response.json();
      setUserSelectedAnimal(data.selectedPetId); // Assuming API returns { selectedPetId: 1 }
    } catch (error) {
      console.error(`Error fetching selected pet:`, error);
    }
  };

  useEffect(() => {
    if( loggedInUserId != null ){
      fetchSelectedPet();
    }
  }, [])

  const [time, setTime] = useState(WORK_TIME);
  const [isRunning, setIsRunning] = useState(false);
  const [isWorkSession, setIsWorkSession] = useState(true);
  const [showPopup, setShowPopup] = useState(false);

  useEffect(() => {
    let timer: NodeJS.Timeout;

    if (isRunning && time > 0) {
      timer = setInterval(() => {
        setTime((prevTime) => prevTime - 1);
      }, 1000);
    } else if (time === 0) {
      playNotification();
    }

    return () => clearInterval(timer);
  }, [isRunning, time, isWorkSession]);

  const playNotification = async () => {
    const notification = new Audio(mp3Notification);
    await notification.play();
    setShowPopup(true); // Show the pop-up when time reaches 0
  };

  const handleClosePopup = () => {
    setShowPopup(false);
    setIsWorkSession(!isWorkSession);
    setTime(isWorkSession ? BREAK_TIME : WORK_TIME);
  };

  const formatTime = (seconds: number) => {
    const minutes = Math.floor(seconds / 60);
    const secs = seconds % 60;
    return `${minutes.toString().padStart(2, "0")}:${secs.toString().padStart(2, "0")}`;
  };

  // get the current selected animal image
const selectAnimalIcon = ( animal_id:number ) => {
  switch(animal_id){
    case 1:
      return dogIcon;
    case 2:
      return catIcon;
    case 3:
      return rabbitIcon;
    case 4:
      return turtleIcon;
    case 5:
      return duckIcon;
    case 6:
      return lhamaIcon;
    case 7:
      return squirrelIcon;
    case 8:
      return tigerIcon;
    case 9:
      return rayIcon;
  }
};

  return (
    <section className="flex flex-col items-center justify-start h-screen bg-violet-100 text-black">
      <img 
        src={selectAnimalIcon(6)} 
        alt={`image_for_animal_${selectedAnimal}`}
        className="w-64 h-64 mt-5"
      />
      
      <h1 className="text-4xl font-bold mb-4 mt-5">
        {isWorkSession ? "Work Session" : "Break Time"}
      </h1>
      <div className="text-6xl font-mono bg-white px-10 py-5 rounded-lg shadow-md">
        {formatTime(time)}
      </div>
      <div className="flex gap-4 mt-5">
        <Button onClick={() => setIsRunning(!isRunning)} className="bg-green-500 text-white">
          {isRunning ? <Pause className="w-6 h-6" /> : <Play className="w-6 h-6" />}
        </Button>
        <Button
          onClick={() => {
            setIsRunning(false);
            setTime(WORK_TIME);
            setIsWorkSession(true);
          }}
          className="bg-red-500 text-white"
        >
          <RotateCcw className="w-6 h-6" />
        </Button>
      </div>

      {/* Pop-up notification */}
      <Dialog open={showPopup} onOpenChange={setShowPopup}>
        <DialogContent className="bg-white rounded-lg shadow-lg p-6">
          <DialogHeader>
            <DialogTitle>
              {isWorkSession ? "Time for a Break!" : "Back to Work!"}
            </DialogTitle>
          </DialogHeader>
          <p className="text-gray-600">
            {isWorkSession
              ? "Great job! Take a short break before the next session."
              : "Break is over! Let's get back to work."}
          </p>
          <Button className="mt-4 bg-violet-500 hover:bg-violet-600 hover:cursor-pointer text-white" onClick={handleClosePopup}>
            OK
          </Button>
        </DialogContent>
      </Dialog>
    </section>
  );
};

export default PomodoroTimer;
