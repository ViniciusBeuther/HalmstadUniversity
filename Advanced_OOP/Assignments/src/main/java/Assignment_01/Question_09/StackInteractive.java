package Assignment_01.Question_07;

import java.util.ArrayList;
import java.util.List;

public class StackInteractive {
    public static void main(String[] args){
//      Initialize the elements to be inserted in the stack
        List<Integer> elements = new ArrayList<>(List.of(1,2,3,4,5,6));

        List<Integer> elementsToPush = new ArrayList<>(List.of(8,9,11,10));

//      Create a Stack instance
        Stack myStack = new Stack( elements );

//      Showing original stack
        System.out.println("Full stack before insertion: " + myStack.getElements());

//      Inserting new elements to the stack and show the new stack
        myStack.push(elementsToPush.size(), elementsToPush);
        System.out.println("Full stack after insertion: " + myStack.getElements());

//      Pop 5 elements and show them as a list
        System.out.println("Elements removed on pop: " + myStack.pop(5));

//      The stack after pop elements
        System.out.println("Full stack after pop: " + myStack.getElements());

//      Show current stack's top/bottom
        System.out.println("Top element:" + myStack.getTop());
        System.out.println("Bottom element:" + myStack.getBottom());
    }
}
