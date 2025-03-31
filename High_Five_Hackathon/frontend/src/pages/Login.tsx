import { useEffect, useState } from "react";
import { Button } from '../components/ui/button';
import { Input } from '../components/ui/input';
import { logIn } from '../hooks/useLogIn';
import '../index.css';
import { UserInformation } from '../types/user';
import { useNavigate } from "react-router-dom";

interface User {
  username: string;
  password: string;
}

interface loginPropsInterface{
  setUserRootInfo: (value: UserInformation) => void;
}

const Login: React.FC<loginPropsInterface> = ( props ) => {
  const [user, setUser] = useState<User>({
    username: '',
    password: ''
  });
  const [userInfo, setUserInfo] = useState<UserInformation | null>(null);
  const [isLoggedIn, setIsLoggedIn] = useState<Boolean>(false);
  const [isInvalid, setIsInvalid] = useState<Boolean>(false);
  const { setUserRootInfo } = props;
  const navigate = useNavigate();
  

  const handleSubmit = async (props: User) => {
    const result: boolean | UserInformation = await logIn({
      username: props.username,
      password: props.password
    });

    if (typeof result === "object") { // Check if it's an object
      setUserInfo(result);
      setUserRootInfo(result);
      setIsLoggedIn(true);
    } else {
      setIsInvalid(true);
      console.error("Login failed or returned an unexpected result.");
    }
  };

  if( isLoggedIn ){
    navigate('/home');
  };

  return (
    <main className='flex items-center justify-center h-[100vh]'>
      <article className='bg-white w-[35%] py-5 px-10 rounded-md shadow-xl flex flex-col gap-2'>
        <h1 className='text-center'>Log In</h1>

        <section>
          <label htmlFor="username">Username</label>
          <Input
            placeholder='username'
            value={user.username}
            onChange={(ev) => setUser(prev => ({ ...prev, username: ev.target.value }))}
          />
        </section>

        <section>
          <label htmlFor="password">Password</label>
          <Input
            placeholder='password'
            type='password'
            value={user.password}
            onChange={(ev) => setUser(prev => ({ ...prev, password: ev.target.value }))}
          />
        </section>
        { isInvalid ? (
          <p className="text-red-500">Invalid Credentials, try again.</p>
        ) : null }
        <section id='login_btn_container'>
          <Button
            className='mt-5 bg-violet-500 hover:bg-violet-700 hover:cursor-pointer'
            onClick={() => handleSubmit(user)}
          >
            Log In
          </Button>
        </section>
      </article>
    </main>
  );
};

export default Login;
