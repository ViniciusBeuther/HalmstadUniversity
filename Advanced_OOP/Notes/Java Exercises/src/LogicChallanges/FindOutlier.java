package LogicChallanges;

import java.util.ArrayList;

public class FindOutlier {
    public static void main(String args[]){
//        int[] n = {2, 4, 0, 100, 4, 11, 2602, 36};
        int[] n = {160, 3, 1719, 19, 11, 13, -21};
        int result = find(n);
        System.out.println(result);
    }

    static int find(int[] integers){
        ArrayList<Integer> odds = new ArrayList<>(); //impar
        ArrayList<Integer> evens = new ArrayList<>(); //par

        for( int num : integers ){
            if( num % 2 == 0 ){
                evens.add(num);
            } else{
                odds.add(num);
            }
        }
        if( odds.size() > 1 ){
            return evens.getFirst();
        } else{
            return odds.getFirst();
        }
    }
}
