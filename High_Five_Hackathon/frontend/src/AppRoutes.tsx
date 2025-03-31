import { useEffect, useState } from 'react';
import Home from './pages/Home';
import Login from './pages/Login';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import { UserInformation } from './types/user';
import Shop from './pages/Shop';
import Stats from './pages/Statistics';

const AppRoutes = () => {
  const [userInformation, setUserInformation] = useState<UserInformation>();
  const defaultUserInfo:UserInformation = {
    user_id: 1,
    username: "admin",
    password: "pass",
    coins: 0,
    selected_pet: 1
  }

  useEffect(() => {
    if(userInformation != null){
      localStorage.setItem('loggedInUserId', userInformation.user_id.toString());
      console.log(`user info changed in root: ${userInformation.coins}`)
    } else{

    }
  }, [userInformation])
  return (
    <Router>
      <Routes>
        <Route path='/' element={<Login setUserRootInfo={setUserInformation} />} />
        <Route path='/home' element={userInformation ? <Home userInformation={userInformation} setUserRootInfo={setUserInformation}  /> : <Home userInformation={defaultUserInfo} setUserRootInfo={setUserInformation}  />} />
        <Route path='/home/stats' element={userInformation ? <Stats /> : <Stats />} />
        <Route path='/home/shop' element={<Shop />} />
      </Routes>
    </Router>
  )
}

export default AppRoutes;