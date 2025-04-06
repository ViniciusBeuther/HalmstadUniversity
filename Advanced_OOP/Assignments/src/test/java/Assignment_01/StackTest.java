package Assignment_01;

import org.junit.jupiter.api.Test;

import java.util.ArrayList;
import java.util.List;

import static org.junit.jupiter.api.Assertions.*;

class StackTest {
    @Test
    void initialization(){
        List<Integer> elements = new ArrayList<>(List.of(1,2,3,4,5));
        Stack myStack = new Stack(elements);

        assertEquals(elements, myStack.getElements());
    }

    @Test
    void popElements(){
        List<Integer> elements = new ArrayList<>(List.of(1,2,3,4,5));
        Stack myStack = new Stack(elements);
        List<Integer> removedElements = new ArrayList<>(List.of(5,4));

        assertEquals(removedElements, myStack.pop(2));
    }

    @Test
    void pushElements(){
        List<Integer> elements = new ArrayList<>(List.of(1,2,3,4,5,6));
        Stack myStack = new Stack(elements);
        List<Integer> elementsToInsert = new ArrayList<>(List.of(10,11,12,13,14));
        List<Integer> expectedResult = new ArrayList<>(List.of(1,2,3,4,5,6,10,11,12,13,14));
        myStack.push(elementsToInsert.size(), elementsToInsert);

        assertEquals(expectedResult, myStack.getElements());
        
    }
}