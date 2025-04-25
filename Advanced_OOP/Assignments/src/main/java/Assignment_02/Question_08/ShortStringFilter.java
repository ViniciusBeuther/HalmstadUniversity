package Assignment_02.Question_08;

public class ShortStringFilter extends Filter {
    @Override
    public boolean accept(String x){
        return x.length() <= 3;
    }
}