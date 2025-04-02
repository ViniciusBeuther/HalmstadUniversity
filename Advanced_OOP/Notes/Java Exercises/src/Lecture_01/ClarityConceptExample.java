package Lecture_01;

import java.util.LinkedList;
import java.util.ListIterator;

public class ClarityConceptExample {
    public static void main(String[] args){
        LinkedList<String> countries = new LinkedList<String>();

        countries.add("A");
        countries.add("B");
        countries.add("C");

        ListIterator<String> iterator = countries.listIterator();
        System.out.println(iterator.next());
        
        while(iterator.hasNext()) {
            System.out.println(iterator.next());
        }
    }
}