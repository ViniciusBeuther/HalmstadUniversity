package Lecture_01;

import java.time.LocalDate;

public class FirstProgram {
    public static void main( String[] args ){
        LocalDate date = LocalDate.now();

        System.out.println(date.getMonth());
    }
}