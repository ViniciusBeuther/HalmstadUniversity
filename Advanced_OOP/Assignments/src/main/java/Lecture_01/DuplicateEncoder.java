package Lecture_01;

import java.util.HashMap;
import java.util.Map;

/*
* The goal of this exercise is to convert a string to a new string where each character in the new string is "(" if that
* character appears only once in the original string, or ")" if that character appears more than once in the original string.
* Ignore capitalization when determining if a character is a duplicate.

* *Examples of expected outputs:
*   "din"      =>  "((("
    "recede"   =>  "()()()"
    "Success"  =>  ")())())"
    "(( @"     =>  "))(("
*
*/

public class DuplicateEncoder {
    public static void main(String[] args){
        String result = endcode("Success");
        System.out.println(result);
    }

    static String endcode(String word){
        Map<Character, Integer> characterMap = new HashMap<Character, Integer>();
        String result = "";

        for(int i=0; i < word.length(); i++){
            Character c = word.toUpperCase().charAt(i);
            if( !characterMap.containsKey(c) ){
                characterMap.put(c, 1);
            } else {
                characterMap.put(c, characterMap.get(c) + 1);
            }
        }
        System.out.println(characterMap);
        for( int j=0; j < word.length(); j++ ){
            Character c = word.toUpperCase().charAt(j);
            if( characterMap.get(c).equals(1) ){
                result = result.concat("(");
            } else {
                result = result.concat(")");
            }
        }
        return result;
    }
}
