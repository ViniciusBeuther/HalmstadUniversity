package Assignment_01.Question_14;

public class Main {
    public static void main(String[] args){
        // Initial list of words for testing class
        String[] words = {"Duck", "Bear", "Fish", "OOP", "AAA"};

        // Instantiate our filter class, which is based on the Filter Interface
        ShortStringFilter shortFilter = new ShortStringFilter();

        // Call the method to filter the words with size <= 3
        String[] goodWords = filter(words, shortFilter);

        // Loop list to print words
        for(String word : goodWords){
            System.out.println(word);
        }
    }

    // Filter data, receives a filter and string list as parameters
    public static String[] filter(String[] a, Filter f){
        int counter = 0;

        // Count how many good words it has to initialize the output array with the correct size
        for(String word : a){
            if( f.accept(word) ){
                counter++;
            }
        }

        String[] acceptedWords = new String[counter];
        int index = 0;

        // Looping over the words and adding them to the output string[]
        for(String word : a){
            if( f.accept(word) ){
                acceptedWords[index] = word;
                index++;
            }
        }

        return acceptedWords;
    }
}
