package Assignment_01.Question_09;

import java.util.ArrayList;
import java.util.List;

public class StackInteractive {
    public static void main(String[] args){
        Message msg_01 = new Message("This is message 01");
        Message msg_02 = new Message("This is message 02");
        Message msg_03 = new Message("This is message 03");
        Message msg_04 = new Message("This is message 04");
        Message msg_05 = new Message("This is message 05");
//      Initialize the elements to be inserted in the stack
        List<Message> elements = new ArrayList<>(List.of(msg_01, msg_02, msg_03));

        List<Message> elementsToPush = new ArrayList<>(List.of(msg_04, msg_05));

//      Create a Stack instance
        Stack myStack = new Stack( elements );

//      Showing original stack
        System.out.println("Full stack before insertion: " + myStack.getElements());

//      Inserting new elements to the stack and show the new stack
        myStack.push(elementsToPush.size(), elementsToPush);
        System.out.println("Full stack after insertion: " + myStack.getElements());

//      Pop 5 elements and show them as a list
        System.out.println("Elements removed on pop: " + myStack.pop(1));

//      The stack after pop elements
        System.out.println("Full stack after pop: " + myStack.getElements());

//      Show current stack's top/bottom
        System.out.println("Top element:" + myStack.getTop());
        System.out.println("Bottom element:" + myStack.getBottom());
    }
}
