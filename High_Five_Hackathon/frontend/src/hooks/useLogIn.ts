interface LogInHookInterface {
  username: string;
  password: string;
}

interface UserResponseInterface {
  user_id: number;
  username: string;
  password: string;
  coins: number;
  selected_pet: number;
}

export const logIn = async ({ username, password }: LogInHookInterface): Promise<UserResponseInterface | boolean> => {
  try {
    const response = await fetch('http://localhost:3001/auth/login', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ username, password })
    });

    const result = await response.json();

    // ✅ Ensure data exists and return only the first user object
    if (result && result.data && result.data.length > 0) {
      return result.data[0]; // 👈 Return a single user object
    }

    return false;
  } catch (error) {
    console.error(error);
    return false;
  }
};
