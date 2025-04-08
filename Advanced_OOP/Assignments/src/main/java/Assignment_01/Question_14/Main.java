package Assignment_01.Question_14;

public class Main {
    public static void main(String[] args){
        String[] words = {"Duck", "Bear", "Fish", "OOP", "AAA"};

        ShortStringFilter shortFilter = new ShortStringFilter();

        String[] goodWords = filter(words, shortFilter);

        // Loop thru the words with size <= 3
        for(String word : goodWords){
            System.out.println(word);
        }
    }

    // Filter data, receives a filter and string list as parameters
    public static String[] filter(String[] a, Filter f){
        int counter = 0;

        for(String word : a){
            if( f.accept(word) ){
                counter++;
            }
        }

        String[] acceptedWords = new String[counter];
        int index = 0;

        for(String word : a){
            if( f.accept(word) ){
                acceptedWords[index] = word;
                index++;
            }
        }

        return acceptedWords;
    }
}
