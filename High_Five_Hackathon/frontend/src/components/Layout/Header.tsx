import '../../index.css';
import { Avatar } from '../ui/avatar';
import { CircleDollarSign, Flame } from 'lucide-react';
import { Button } from '../ui/button';
import { Link } from 'react-router-dom';

const Header = () => {
  return (
    <header className="bg-white shadow-lg p-4">
      <div className="flex justify-between items-center">
        {/* Left side: Avatar */}
        <article className="flex items-center">
          <Avatar className="w-14 h-14">
            <img src="https://github.com/shadcn.png" alt="@shadcn" />
          </Avatar>
        </article>

        {/* Center: Navigation Links */}
        <nav className="flex gap-6 items-center justify-center text-xl pl-[150px]">
          <Link to={'/home'} className="text-gray-700 hover:text-violet-500 transition duration-200">
            Home
          </Link>
          <Link to={'/home/shop'} className="text-gray-700 hover:text-violet-500 transition duration-200">
            Shop
          </Link>
          <Link to={'/home/stats'} className="text-gray-700 hover:text-violet-500 transition duration-200">
            Statistics
          </Link>
        </nav>

        {/* Right side: Flame & Dollar */}
        <article className="flex items-center gap-8">
          <p className="flex items-center text-lg text-red-500">
            <Flame className="w-7 h-7 mr-2" />
            1 Day
          </p>
          <p className="flex items-center text-lg text-yellow-400">
            <CircleDollarSign className="w-7 h-7 mr-2" />
            0.00
          </p>
        </article>
      </div>
    </header>
  );
}

export default Header;
