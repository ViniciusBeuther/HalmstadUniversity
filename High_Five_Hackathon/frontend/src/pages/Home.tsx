import React, { useEffect, useState } from 'react'
import type { UserInformation } from '../types/user';
import Header from '../components/Layout/Header';
import PomodoroTimer from '../components/PomodoroTimer/PomodoroTimer';

interface homePropInterface{
  userInformation: UserInformation,
  setUserRootInfo: (value: UserInformation) => void;
}

const Home:React.FC<homePropInterface> = ({ userInformation, setUserRootInfo }) => {
  return (
    <main className='h-[100vh] overflow-y-hidden'>
      <Header />
      <article className='h-[100vh]'>
        <PomodoroTimer selectedAnimal={userInformation.selected_pet} />
      </article>      
    </main>
  )
}

export default Home;
