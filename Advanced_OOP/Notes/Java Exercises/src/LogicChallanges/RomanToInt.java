package LogicChallanges;

import java.util.HashMap;
import java.util.Map;

public class RomanToInt {
    public static void main(String[] args){
        String case1 = "IV";

        System.out.println(romanToInt(case1));
    }

    public static int romanToInt(String s){
        int counter = 0;
        Map<Character, Integer> charMap = new HashMap<>();
        charMap.put('I', 1);
        charMap.put('V', 5);
        charMap.put('X', 10);
        charMap.put('L', 50);
        charMap.put('C', 100);
        charMap.put('D', 500);
        charMap.put('M', 1000);

        for(int i = 0; i < s.length(); i++){
            int current = charMap.get(s.charAt(i));
            if( i < s.length() - 1 && current < charMap.get(s.charAt(i + 1)) ){
                counter -= current;
            } else{
                counter += current;
            }
        }
        return counter;
    }
}
